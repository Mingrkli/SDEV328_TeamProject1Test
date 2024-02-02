const userPosts = document.querySelectorAll(".user-posts");

// For each posts
// ============================================================
userPosts.forEach((post) => {
    // if user press the delete button, a confirm will show up to ask the user for the final confirmation
    post.querySelector(".delete-confirm").addEventListener("click", (e) => {
        e.target.classList.toggle("hidden");
        post.querySelector(".delete-confirm-final").classList.toggle("hidden");
    });

    post.querySelector(".delete-confirm-final-cancel-btn").addEventListener(
        "click",
        () => {
            post.querySelector(".delete-confirm").classList.toggle("hidden");
            post.querySelector(".delete-confirm-final").classList.toggle(
                "hidden"
            );
        }
    );
});

// Create Posts field
// ============================================================
const createPostsBtn = document.querySelectorAll(".createPosts-btn");
const createPostsField = document.querySelector("#createPosts-field");
// fields
const characterLimitTitleField = document.querySelector(
    "#createPostContainer #createPostsTitleField"
);
const characterLimitDescriptionField = document.querySelector(
    "#createPostContainer textarea"
);
// fields span
const characterLimitSpanTitle = document.querySelector(
    "#characterLimitTitle span"
);
const characterLimitSpanDescription = document.querySelector(
    "#characterLimitDescription span"
);

// If createPosts-btn is clicked, show the Create Posts field
createPostsBtn.forEach((e) => {
    e.addEventListener("click", () => {
        createPostsField.classList.toggle("hidden");
    });
});

// Checks the characters limit amount and show it for the title and description
characterLimitTitleField.addEventListener("input", (e) => {
    characterLimitSpanTitle.innerHTML = characterLimitTitleField.value.length;
});
characterLimitDescriptionField.addEventListener("input", (e) => {
    characterLimitSpanDescription.innerHTML =
        characterLimitDescriptionField.value.length;
});
