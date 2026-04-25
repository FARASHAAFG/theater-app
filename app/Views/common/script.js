console.log(window.location.href);
function confirmDeleteShow(showId) {
    // Fix 1: Log the actual variables, not hardcoded strings
    console.log("showId: " + showId);

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            // Fix 2: Navigate BEFORE showing success (or let the server response handle it)
            window.location.href = "/theater-app/admin/show/delete/" + showId;

            // Optional: show success only if you're NOT redirecting
            // Swal.fire({ title: "Deleted!", text: "Show has been deleted.", icon: "success" });
        }
    });

    // Fix 3: Return false so the <a> tag doesn't navigate immediately
    return false;
}
// TODO: add your reusable JavaScript imports here.
