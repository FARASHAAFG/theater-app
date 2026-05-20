<?php

require_once __DIR__ . '/../common/header.php';

$rows = [
    'A' => $data['row_A'] ?? [],
    'B' => $data['row_B'] ?? [],
    'C' => $data['row_C'] ?? [],
];
$booked_seats = $data['bookedSeatIds'] ?? [];
?>

<div class="container text-center">
    <h1><?= hs(t('booking.seats_heading')) ?></h1>

    <form method="post" action="<?= APP_BASE_URL ?>/user/booking" id="seatForm">
        <?php foreach ($rows as $label => $seats): ?>
            <div class="row justify-content-center mb-2">
                <div class="col-auto fw-bold"><?= htmlspecialchars($label) ?></div>
                <?php foreach ($seats as $seat): ?>
                    <?php $isBooked = in_array($seat['seat_id'], $booked_seats); ?>
                    <div class="col-auto">
                        <button type="button"
                            class="seat btn <?= $isBooked ? 'btn-danger' : 'btn-outline-dark' ?>"
                            data-seat="<?= htmlspecialchars((string) $seat['seat_id']) ?>"
                            <?= $isBooked ? 'disabled' : '' ?>>
                            <?= htmlspecialchars((string) $seat['seat_number']) ?>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <div id="hiddenSeats"></div>
        <button type="submit" class="btn btn-success mt-3" id="bookBtn" disabled><?= hs(t('booking.book')) ?></button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        let selectedSeats = [];
        $(".seat:not([disabled])").on("click", function() {
            const seat = $(this).data("seat");
            $(this).toggleClass("btn-success btn-outline-dark");
            if ($(this).hasClass("btn-success")) {
                selectedSeats.push(seat);
            } else {
                selectedSeats = selectedSeats.filter(s => s !== seat);
            }
            $("#hiddenSeats").html(
                selectedSeats.map(s => `<input type="hidden" name="seats[]" value="${s}">`).join("")
            );
            $("#bookBtn").prop("disabled", selectedSeats.length === 0);
        });
    </script>
</div>

<?php require_once __DIR__ . '/../common/footer.php'; ?>
