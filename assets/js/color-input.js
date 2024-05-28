document.addEventListener("DOMContentLoaded", function() {
    
    const backgroundColorPreviewInput = document.getElementById("backgroundColorPreview");
    const backgroundColorSelectionInput = document.getElementById("backgroundColorSelection");

    // Get the elements FOR HOVER COLOR PICKER
    const hoverColorPreviewInput = document.getElementById("hoverColorPreview");
    const hoverColorSelectionInput = document.getElementById("hoverColorSelection");

    // Function to update preview body color input and store value in localStorage
    function updateColor() {
        const colorValue = this.value;
        if (this === backgroundColorSelectionInput) {
            backgroundColorPreviewInput.value = colorValue;
        } else if (this === backgroundColorPreviewInput) {
            backgroundColorSelectionInput.value = colorValue;
        } else if (this === hoverColorSelectionInput) {
            hoverColorPreviewInput.value = colorValue;
        } else if (this === hoverColorPreviewInput) {
            hoverColorSelectionInput.value = colorValue;
        }
        localStorage.setItem(this.id, colorValue);
    }

    // Event listener for input event on color inputs
    backgroundColorSelectionInput.addEventListener("input", updateColor);
    backgroundColorPreviewInput.addEventListener("input", updateColor);
    hoverColorSelectionInput.addEventListener("input", updateColor);
    hoverColorPreviewInput.addEventListener("input", updateColor);
});
