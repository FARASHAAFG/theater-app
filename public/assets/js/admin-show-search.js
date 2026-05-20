document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const typeFilter = document.getElementById("typeFilter");
    const loadingSpinner = document.getElementById("loadingSpinner");
    const tableBody = document.getElementById("showsTableBody");
    const defaultTableBody = document.getElementById("defaultShowsTableBody");

    if (!searchInput || !typeFilter || !tableBody) {
        return;
    }

    const i18n = window.i18n || {};

    async function performSearch() {
        const search = searchInput.value.trim();
        const type = typeFilter.value;

        loadingSpinner.style.display = "block";
        const shows = await fetchShows(search, type);
        loadingSpinner.style.display = "none";

        if (defaultTableBody) {
            defaultTableBody.style.display = "none";
        }
        tableBody.style.display = "";
        renderShowsTable(shows, tableBody);
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
        showTableError(i18n.loadError || "Failed to load shows. Please try again.");
        return [];
    }
}

function showTableError(message) {
    const tableBody = document.getElementById("showsTableBody");
    if (!tableBody) return;

    tableBody.innerHTML = `<tr><td colspan="12" class="text-center text-danger py-3">${escapeHtml(message)}</td></tr>`;
}

function renderShowsTable(shows, tableBody) {
    const i18n = window.i18n || {};
    const base = window.APP_BASE_URL || "";

    tableBody.textContent = "";

    if (shows.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="12" class="text-center text-muted py-3">${escapeHtml(i18n.noResults || "No shows found.")}</td>`;
        tableBody.appendChild(row);
        return;
    }

    shows.forEach((show) => {
        tableBody.appendChild(createShowRow(show, base, i18n));
    });
}

function createShowRow(show, base, i18n) {
    const row = document.createElement("tr");
    const showId = show.show_id;
    const hasPoster = show.poster_id != null && show.poster_id !== "" && show.poster_id !== 0;
    const isActive = show.is_active == 1 || show.is_active === "1" || show.is_active === true;
    const activeLabel = isActive ? (i18n.yes || "Yes") : (i18n.no || "No");
    const durationLabel = (i18n.durationMinutes || "%minutes% min").replace("%minutes%", escapeHtml(String(show.duration ?? "")));

    const posterBadge = hasPoster
        ? `<span class="badge bg-success"><i class="bi bi-star-fill"></i> ${escapeHtml(i18n.hasPoster || "Has poster")}</span>`
        : `<span class="badge bg-danger"><i class="bi bi-star-fill"></i> ${escapeHtml(i18n.noPoster || "No poster")}</span>`;

    const posterBtnClass = hasPoster ? "info" : "warning";
    const posterBtnLabel = hasPoster
        ? (i18n.changePoster || "Change poster")
        : (i18n.addPoster || "Add poster");

    const confirmDelete = i18n.confirmDelete || "Are you sure you want to delete this show?";

    row.innerHTML = `
        <td>${escapeHtml(String(showId))}</td>
        <td>${escapeHtml(show.title)}</td>
        <td>${escapeHtml(show.title_fr)}</td>
        <td>${durationLabel}</td>
        <td>${escapeHtml(show.genre)}</td>
        <td>${escapeHtml(show.language)}</td>
        <td>${escapeHtml(show.show_type)}</td>
        <td>${escapeHtml(activeLabel)}</td>
        <td>${posterBadge}</td>
        <td>
            <a class="btn btn-primary" href="${base}/admin/show_details/${escapeHtml(String(showId))}">
                ${escapeHtml(i18n.viewDetails || "View details")}
            </a>
        </td>
        <td>
            <a class="btn btn-${posterBtnClass}" href="${base}/admin/upload/${escapeHtml(String(showId))}">
                ${escapeHtml(posterBtnLabel)}
            </a>
        </td>
        <td>
            <a href="${base}/admin/show/delete/${escapeHtml(String(showId))}"
                class="btn btn-danger btn-sm"
                onclick="return confirm('${escapeJsString(confirmDelete)}')">
                ${escapeHtml(i18n.delete || "Delete")}
            </a>
        </td>
    `;

    return row;
}

function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text == null ? "" : String(text);
    return div.innerHTML;
}

function escapeJsString(text) {
    return String(text)
        .replace(/\\/g, "\\\\")
        .replace(/'/g, "\\'")
        .replace(/\r/g, "\\r")
        .replace(/\n/g, "\\n");
}
