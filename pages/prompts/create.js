async function initCreatePage() {
    const response = await API.categories.list();
    const select = document.getElementById('category');
    if (select && response.success) {
        select.innerHTML = response.data.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
    }
}

document.getElementById("createPromptForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();
    
    const promptData = {
        title: document.getElementById("title").value.trim(),
        content: document.getElementById("text").value,
        category_id: document.getElementById("category").value,
        is_public: document.getElementById("public").checked ? 1 : 0
    };

    const response = await API.prompts.create(promptData);
    
    if (response.success) {
        showToast("Prompt created successfully!");
        setTimeout(() => {
            window.location.href = "prompts.php";
        }, 1000);
    } else {
        showToast(response.message, "error");
    }
});

