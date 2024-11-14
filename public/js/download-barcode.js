
  document.addEventListener("DOMContentLoaded", function() {
        const downloadButtons = document.querySelectorAll(".download-btn");
        downloadButtons.forEach(button => {
            button.addEventListener("click", function() {
                const code = button.getAttribute("data-code");
                const imageUrl = `/barcodes/${code}.png`;
                const link = document.createElement("a");
                link.href = imageUrl;
                link.download = `${code}.png`;
                link.style.display = "none";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        });
    });
