import $ from "jquery";

declare global {
    interface Window {
        Livewire: any;
    }
}

$(function () {
    $(document).on("click", "#close-toast", function () {
        console.log("Toast close button clicked");

        if (window.Livewire && typeof window.Livewire.navigate === "function") {
            window.Livewire.navigate(window.location.pathname);
        } else {
            window.location.reload();
        }
    });
});
