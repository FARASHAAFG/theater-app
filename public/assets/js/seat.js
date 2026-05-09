document.querySelectorAll(".seat.available").forEach((seat) => {
    seat.addEventListener("click", function () {
        this.classList.toggle("selected");
    });
});

document.getElementById("bookBtn").addEventListener("click", async () => {
    console.log("sasdas");
    let selected = [];

    document.querySelectorAll(".seat.selected").forEach((seat) => {
        selected.push(seat.dataset.seat);
    });

    const res = await fetch("/book-seats", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ seats: selected }),
    });

    const data = await res.json();
    alert(data.message);
});
