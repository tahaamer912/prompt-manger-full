async function initSettingsPage() {
    const response = await API.auth.status();
    if (response.success) {
        document.getElementById("profileUsername").value = response.data.username || '';
        document.getElementById("profileEmail").value = response.data.email || '';
    }

    document.getElementById("settingsForm").addEventListener("submit", async (e) => {
        e.preventDefault();
        const username = document.getElementById("profileUsername").value;
        const email = document.getElementById("profileEmail").value;

        const res = await API.auth.updateProfile(username, email);
        if (res.success) {
            showToast("Profile updated successfully!");
        } else {
            showToast(res.message, "error");
        }
    });
}

