document.addEventListener("DOMContentLoaded", function () {
    console.log("Show Search JS Dom Content Loading Initiated");
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const loadingSpinner = document.getElementById("loadingSpinner");

    async function performSearch() {
        const search = await searchInput.value.trim();
        const type = await typeFilter.value;

        loadingSpinner.style.display = "block";
        const shows = await fetchShows(search, type);
        loadingSpinner.style.display = "none";

        renderShows(shows);
    }

    const debouncedSearch = debounce(performSearch, 300);

    searchInput.addEventListener("input", debouncedSearch);
    typeFilter.addEventListener("change", performSearch);

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            searchInput.value = "";
            typeFilter.value = "";
            performSearch();
        }
    });
});

function debounce(func, delay) {
    let timeoutId;
    return function (...args) {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(this, args), delay);
    };
}

async function fetchShows(searchInput, typeFilter) {
    try {
        const params = new URLSearchParams();
        if (searchInput) params.append("q", searchInput);
        if (typeFilter) params.append("type", typeFilter);

        console.log("Fetching Searched Shows...");
        console.log(`Windows app base url is ${window.APP_BASE_URL}`);
        const response = await fetch(
            `${window.APP_BASE_URL}/shows/search?${params.toString()}`,
        );

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const data = await response.json();
        return data.shows || [];
    } catch (error) {
        console.error("Fetch error:", error);
        showError("Failed to load shows. Please try again.");
        return [];
    }
}

function showError(message) {
    const container = document.getElementById("searchResults");
    container.textContent = "";
    const alert = document.createElement("div");
    alert.className = "col-12";
    alert.innerHTML = `<div class="alert alert-danger" role="alert">${message}</div>`;
    container.appendChild(alert);
}

function renderShows(shows) {
    const resultsContainer = document.getElementById("searchResults");
    const defaultContainer = document.getElementById("defaultShows");

    if (defaultContainer) defaultContainer.style.display = "none";
    resultsContainer.textContent = "";

    if (shows.length === 0) {
        const alert = document.createElement("div");
        alert.className = "col-12";
        alert.innerHTML =
            '<div class="alert alert-info" role="alert">No shows found matching your search.</div>';
        resultsContainer.appendChild(alert);
        return;
    }

    shows.forEach((show) => {
        resultsContainer.appendChild(createShowCard(show));
    });
}

function createShowCard(show) {
    const col = document.createElement("div");
    col.className = "col-md-4 mb-4";

    console.log("Image: " + show.poster_image);

    col.innerHTML = `
                    <div class="card h-100" style="width: 100%;">
                        <img src="${escapeHtml(`/theater-app/uploads/images/${show.poster_image}`)}">
                        <div class="card-body">
                            <h5 class="card-title">${escapeHtml(show.title)}</h5>
                        </div>
                        <ul class="list-group list-group-flush">

                            <li class="list-group-item">Genre : ${escapeHtml(show.genre)}</li>
                            <li class="list-group-item">Language : ${escapeHtml(show.language)}</li>


                            <li class="list-group-item">Duration : ${escapeHtml(show.duration)} minutes</li>


                        </ul>
                        <div class="card-body">
                            <a href="/theater-app/user/show_details/${escapeHtml(show.show_id)}" class="btn btn-primary btn-lg">Details</a>
                            <a href="/theater-app/user/booking/${escapeHtml(show.show_id)}" class="btn btn-success btn-lg">Ticket</a>
                        </div>
                    </div>
    `;

    return col;
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text;
    return div.innerHTML;
}
