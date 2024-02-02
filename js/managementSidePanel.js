// Management Panel
// =======================================================================
const managements = document.querySelector("#managements");
const managementPanelCloseBtn = document.querySelector(
    "#managementPanelCloseBtn"
);
const managementPanelOpenBtn = document.querySelector(
    "#managementPanelOpenBtn"
);

managementPanelCloseBtn.addEventListener("click", () => {
    managements.classList.remove("show");
});

managementPanelOpenBtn.addEventListener("click", () => {
    managements.classList.add("show");
});

// Create New Management Container
// =======================================================================
const createNewManagementUserBtns = document.querySelector(
    "#createNewManagementUserBtns"
);
const createNewManagementContainer = document.querySelector(
    "#createNewManagementContainer"
);

createNewManagementUserBtns
    .querySelector("#newManagementBtn")
    .addEventListener("click", () => {
        createNewManagementContainer.classList.toggle("hidden");
    });
