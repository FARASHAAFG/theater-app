<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\showModel;
use App\Helpers\FileUploadHelper;
use App\Helpers\FlashMessage;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadController extends BaseController
{
  private const UPLOAD_CONFIG = [
    'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
    'maxSize' => 5 * 1024 * 1024,
    'filenamePrefix' => 'upload_',
  ];

  public function __construct(Container $container, private showModel $showModel)
  {
    parent::__construct($container);
  }

  public function index(Request $request, Response $response, array $args): Response
  {
    $showId = (int) ($args['id'] ?? 0);
    $show = $this->showModel->getByShowId($showId);

    if ($show === false) {
      FlashMessage::error(t('admin.upload.show_not_found'));
      return $this->redirect($request, $response, 'show.index');
    }

    $poster = $this->showModel->getPosterByShowId($showId);

    return $this->render($response, 'admin/uploadView.php', [
      'title' => t('admin.upload.title'),
      'id' => $showId,
      'show' => $show,
      'poster' => $poster ?: [],
    ]);
  }

  public function upload(Request $request, Response $response, array $args): Response
  {
    $showId = (int) ($args['id'] ?? 0);
    $show = $this->showModel->getByShowId($showId);

    if ($show === false) {
      FlashMessage::error(t('admin.upload.show_not_found'));
      return $this->redirect($request, $response, 'show.index');
    }

    $files = $request->getUploadedFiles();

    if (!isset($files['myfile'])) {
      FlashMessage::error(t('admin.upload.no_file'));
      return $this->redirect($request, $response, 'upload.index', ['id' => $showId]);
    }

    $uploadedFile = $files['myfile'];

    $config = array_merge(self::UPLOAD_CONFIG, [
      'directory' => APP_UPLOAD_DIR,
    ]);

    $result = FileUploadHelper::upload($uploadedFile, $config);

    if (!$result->isSuccess()) {
      $errors = $result->getErrors();
      $message = !empty($errors) ? implode(' ', $errors) : $result->getMessage();
      FlashMessage::error($message ?: t('admin.upload.failed'));
      return $this->redirect($request, $response, 'upload.index', ['id' => $showId]);
    }

    $filename = $result->getData()['filename'] ?? null;

    if (!$filename) {
      FlashMessage::error('Upload succeeded but filename was missing.');
      return $this->redirect($request, $response, 'upload.index', ['id' => $showId]);
    }

    $this->showModel->deletePosterByShowId($showId);
    $saved = $this->showModel->createPoster($showId, true, $filename);

    if (!$saved) {
      FlashMessage::error('Image uploaded but could not save poster record.');
      return $this->redirect($request, $response, 'upload.index', ['id' => $showId]);
    }

    FlashMessage::success(t('admin.upload.success'));

    return $this->redirect($request, $response, 'show.index');
  }
}
