<?php
require_once __DIR__ . '/../common/header.php';

$rows = [
    "A" => $data["row_A"] ?? [],
    "B" => $data["row_B"] ?? [],
    "C" => $data["row_C"] ?? [],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Selection</title>
</head>

<body>

    <div class="container text-center">
        <h1>Seats</h1>

        <form method="post" action="/theater-app/user/booking" id="seatForm">
            <?php foreach ($rows as $label => $seats): ?>
                <div class="row justify-content-center mb-2">
                    <div class="col-auto fw-bold"><?= htmlspecialchars($label) ?></div>

                    <?php foreach ($seats as $seat): ?>
                        <div class="col-auto">
                            <button
                                type="button"
                                class="seat btn btn-outline-dark"
                                data-seat="<?= htmlspecialchars($label . $seat['seat_number']) ?>">
                                <?= htmlspecialchars($seat['seat_number']) ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

            <!-- Hidden inputs get added here by JS when seats are clicked -->
            <div id="hiddenSeats"></div>

            <button type="submit" class="btn btn-success mt-3" id="bookBtn" disabled>Book</button>
        </form>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
            let selectedSeats = [];

            $(".seat").on("click", function() {
                const seat = $(this).data("seat");
                $(this).toggleClass("btn-success btn-outline-dark");

                if ($(this).hasClass("btn-success")) {
                    selectedSeats.push(seat);
                } else {
                    selectedSeats = selectedSeats.filter(s => s !== seat);
                }

                // Rebuild hidden inputs to match selected seats
                $("#hiddenSeats").html(
                    selectedSeats.map(s => `<input type="hidden" name="seats[]" value="${s}">`).join("")
                );

                $("#bookBtn").prop("disabled", selectedSeats.length === 0);
            });
        </script>

</body>

</html>
