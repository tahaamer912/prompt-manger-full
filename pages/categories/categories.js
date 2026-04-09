async function initCategoriesPage() {
    await fetchCategories();
}

async function fetchCategories() {
    const response = await API.categories.list();
    const list = document.getElementById("categoryList");
    if (!list || !response.success) return;

    const cats = response.data;
    if (cats.length === 0) {
        list.innerHTML = `<li style="text-align: center; color: var(--text-secondary); padding: 20px;">No categories found.</li>`;
        return;
    }

    list.innerHTML = cats.map(c => `
        <li style="display: flex; justify-content: space-between; align-items: center; background: var(--bg-primary); padding: 12px 16px; border-radius: 8px; border: 1px solid var(--border);">
            <span>${c.name} ${c.user_id === null ? '<small style="color: var(--text-secondary); margin-left:8px;">(Default)</small>' : ''}</span>
            ${c.user_id !== null ? 
                `<button onclick="deleteCategory(${c.id}, '${escapeHtml(c.name)}')" class="btn-icon" style="color: var(--danger);" title="Delete 🗑">🗑</button>` 
                : ''}
        </li>
    `).join('');
}

document.getElementById("addCategoryForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();
    const newCat = document.getElementById("newCategory").value.trim();
    if (!newCat) return;

    const response = await API.categories.create(newCat);
    if (response.success) {
        showToast("Category added successfully!");
        document.getElementById("newCategory").value = "";
        fetchCategories();
    } else {
        showToast(response.message || "Error adding category.", "error");
    }
});

async function deleteCategory(id, name) {
    if (confirm(`Are you sure you want to delete the category "${name}"?`)) {
        const response = await API.categories.delete(id);
        if (response.success) {
            showToast("Category deleted successfully!");
            fetchCategories();
        } else {
            showToast(response.message, "error");
        }
    }
}

