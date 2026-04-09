async function initViewPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const id = urlParams.get("id");
    if (!id) return;

    const response = await API.prompts.get(id);

    if (response.success) {
        const prompt = response.data;
        document.getElementById("viewTitle").innerText = prompt.title;
        document.getElementById("viewText").innerText = prompt.content;
        document.getElementById("viewCategory").innerText = (prompt.category_name || "Uncategorized") + (parseInt(prompt.is_public) ? ' (🌍 Public)' : ' (🔒 Private)');
        
        const copyBtn = document.getElementById("copyBtn");
        if (copyBtn) {
            copyBtn.onclick = function() {
                navigator.clipboard.writeText(prompt.content).then(() => {
                    const oldText = copyBtn.innerText;
                    copyBtn.innerText = "Copied!";
                    setTimeout(() => { copyBtn.innerText = oldText; }, 2000);
                });
            };
        }
    } else {
        document.getElementById("viewTitle").innerText = "Prompt Not Found";
        document.getElementById("viewText").innerText = "Sorry, we couldn't find the prompt you're looking for.";
    }
}

