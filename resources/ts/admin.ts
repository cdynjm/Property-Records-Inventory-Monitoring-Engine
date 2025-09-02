import $ from "jquery";
import axios from "axios";
declare global {
    interface Window {
        Livewire: any;
    }
}

//ISSUER FUNCTIONS:

$(function () {

    let issuerID: string | null = null;

    $(document).on("submit", "#create-issuer", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-issuer-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/create-issuer", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Name is already taken";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#edit-issuer", function (e) {
        e.preventDefault();
        issuerID = $(this).data("id");
        const issuerName = $(this).data("name");
        const issuerPosition = $(this).data("position");
        if (issuerID) {
            $("#issuer-name").val(issuerName);
            $("#issuer-position").val(issuerPosition);
        }
    });

    $(document).on("submit", "#update-issuer", function (e) {
        e.preventDefault();

        const formData = new FormData(this as HTMLFormElement);
        formData.append("issuerID", issuerID || "");
        formData.append("_method", "PATCH");

        const $btn = $(".save-issuer-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/update-issuer", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[1].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Name is already taken";
                    }
                    $(toast[1]).fadeIn(100);
                    setTimeout(() => $(toast[1]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#delete-issuer", function (e) {
        e.preventDefault();
        issuerID = $(this).data("id");
    });

    $(document).on("click", "#delete-issuer-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        if (!issuerID) {
            alert("No issuer selected to delete!");
            return;
        }

        $btn.prop("disabled", true).text("Deleting...");

        axios
            .delete("/admin/delete-issuer", { data: { issuerID } })
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("There was an error deleting the issuer.");
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Delete");
            });
    });
});

//PERSONNEL FUNCTIONS:

$(function () {
    $(document).on("change", "#received-from", function (e) {
        let position = $(this).find(':selected').data('position') || '';
        $('#received-from-position').val(position);
    });
})

//ICS FUNCTIONS:

$(function () {
    $(document).on("submit", "#create-ics-form", function (e) {
       e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-ics-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/create-ics", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in saving ICS";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });
});