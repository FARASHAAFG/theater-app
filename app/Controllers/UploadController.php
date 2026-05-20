<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Domain\Models\showModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use LDAP\Result;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller for uploads
 */
class UploadController extends BaseController
{
    /**
     * Constructor for upload controller
     * @param Container $container
     * @param showModel $showModel
     */
    public function __construct(Container $container, private showModel $showModel)
    {
        parent::__construct($container);
    }
    //TODO: Add a constructor that calls the parent constructor.

    /**
     * Display the upload form.
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        // TODO: Create a $data array with 'title' => 'File Upload'

        $id = (int)$args['id'];
        $poster = $this->showModel->getPosterByShowId($id);


        return $this->render($response, 'admin/uploadView.php', [
            'id' => $id,
            'poster' => $poster
        ]);


        // TODO: Render 'admin/upload/uploadView.php' view and pass $data

    }

    /**
     * Processes file upload.
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function upload(Request $request, Response $response, array $args): Response
    {
        // TODO: Get uploaded files using $request->getUploadedFiles()
        // TODO: Extract 'myfile' from the array
        $id = (int)$args['id'];
        $files = $request->getUploadedFiles();
        $uploaded_files = $files['myfile'];

        // TODO: Create $config array with:
        //       - 'directory' => APP_BASE_DIR_PATH . '/public/uploads/images'
        //       - 'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif']
        //       - 'maxSize' => 2 * 1024 * 1024 (2MB in bytes)
        //       - 'filenamePrefix' => 'upload_'
        $config = [
            'directory' => APP_BASE_DIR_PATH . '/public/uploads/images',
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            'maxSize' => 2 * 1024 * 1024, //(2MB in bytes)
            'filenamePrefix' => 'upload_'
        ];

        // TODO: Call FileUploadHelper::upload() with uploaded file and config
        $result = FileUploadHelper::upload($uploaded_files, $config);


        // TODO: Check if result is successful using isSuccess()
        // If successful:
        //   1. Get the filename from the result data
        //   2. Retrieve the existing 'uploaded_files' array from the session (default to [])
        //   3. Append the new filename to the array and save it back to the session
        //   4. Display a success flash message
        // If not successful:
        //   1. Get the error message from the result object
        //   2. Display an error flash message
        if ($result->isSuccess()) {
            $filename = $result->getData()["filename"];

            $is_used = true;

            // 1. récupérer session
            $session_files = SessionManager::get('uploaded_files') ?? [];
            $session_files[] = $filename;



            $this->showModel->deletePosterById($id);


            $this->showModel->createPoster($id, $is_used, $filename);



            // 3. save session
            SessionManager::set('uploaded_files', $session_files);

            return $this->redirect($request, $response, 'upload.index', [
                'id' => $id
            ]);

            //FlashMessage::success($result->getMessage());
        } else {
            // afficher erreurs
            $errors = $result->getErrors();
            FlashMessage::error("error");

            //FlashMessage::error(implode(", ", $errors));
        }


        return $this->redirect($request, $response, 'upload.index', [
            'id' => $id
        ]);
        // TODO: Redirect back to 'upload.index'

    }
}
