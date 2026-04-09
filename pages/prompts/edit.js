async function initEditPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    
    if (!id) {
        showToast("No prompt ID provided!", "error");
        setTimeout(() => window.location.href = "prompts.php", 1000);
        return;
    }

    // Load categories first
    const catResponse = await API.categories.list();
    const select = document.getElementById('category');
    if (select && catResponse.success) {
        select.innerHTML = catResponse.data.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
    }

    // Load prompt data
    const response = await API.prompts.get(id);
    if (response.success) {
        const prompt = response.data;
        document.getElementById("title").value = prompt.title || "";
        document.getElementById("text").value = prompt.content || "";
        document.getElementById("category").value = prompt.category_id || "";
        document.getElementById("public").checked = !!parseInt(prompt.is_public);
    } else {
        showToast("Prompt not found!", "error");
        setTimeout(() => window.location.href = "prompts.php", 1000);
    }
}

document.getElementById("editPromptForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = new URLSearchParams(window.location.search).get("id");
    const promptData = {
        id: id,
        title: document.getElementById("title").value.trim(),
        content: document.getElementById("text").value,
        category_id: document.getElementById("category").value,
        is_public: document.getElementById("public").checked ? 1 : 0
    };

    const response = await API.prompts.update(promptData);

    if (response.success) {
        showToast("Prompt updated successfully!");
        setTimeout(() => {
            window.location.href = "prompts.php";
        }, 1000);
    } else {
        showToast(response.message, "error");
    }
});

