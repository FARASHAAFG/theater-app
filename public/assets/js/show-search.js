document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const loadingSpinner = document.getElementById("loadingSpinner");
    const i18n = window.i18n || {};

    async function performSearch() {
        const search = searchInput.value.trim();
        const type = typeFilter.value;

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
    const i18n = window.i18n || {};
    try {
        const params = new URLSearchParams();
        if (searchInput) params.append("q", searchInput);
        if (typeFilter) params.append("type", typeFilter);

        const base = window.APP_BASE_URL || "";
        const response = await fetch(`${base}/shows/search?${params.toString()}`);

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const data = await response.json();
        return data.shows || [];
    } catch (error) {
        console.error("Fetch error:", error);
        showError(i18n.loadError || "Failed to load shows. Please try again.");
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
    const i18n = window.i18n || {};
    const resultsContainer = document.getElementById("searchResults");
    const defaultContainer = document.getElementById("defaultShows");

    if (defaultContainer) defaultContainer.style.display = "none";
    resultsContainer.textContent = "";

    if (shows.length === 0) {
        const alert = document.createElement("div");
        alert.className = "col-12";
        alert.innerHTML = `<div class="alert alert-info" role="alert">${i18n.noResults || "No shows found."}</div>`;
        resultsContainer.appendChild(alert);
        return;
    }

    shows.forEach((show) => {
        resultsContainer.appendChild(createShowCard(show));
    });
}

function createShowCard(show) {
    const i18n = window.i18n || {};
    const base = window.APP_BASE_URL || "";
    const col = document.createElement("div");
    col.className = "col-md-4 mb-4";

    col.innerHTML = `
        <div class="card h-100" style="width: 100%;">
            <img src="${escapeHtml(`${base}/uploads/images/${show.poster_image}`)}" alt="">
            <div class="card-body">
                <h5 class="card-title">${escapeHtml(show.title)}</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">${escapeHtml(i18n.genre || "Genre")}: ${escapeHtml(show.genre)}</li>
                <li class="list-group-item">${escapeHtml(i18n.language || "Language")}: ${escapeHtml(show.language)}</li>
                <li class="list-group-item">${escapeHtml(i18n.duration || "Duration")}: ${escapeHtml(show.duration)} min</li>
            </ul>
            <div class="card-body">
                <a href="${base}/user/show_details/${escapeHtml(show.show_id)}" class="btn btn-primary btn-lg">${escapeHtml(i18n.details || "Details")}</a>
                <a href="${base}/user/booking/${escapeHtml(show.show_id)}" class="btn btn-success btn-lg">${escapeHtml(i18n.bookTicket || "Book")}</a>
            </div>
        </div>
    `;

    return col;
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text == null ? "" : String(text);
    return div.innerHTML;
}
