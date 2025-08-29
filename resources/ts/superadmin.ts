import $ from "jquery";
import axios from "axios";
import Swal from "sweetalert2";
declare global {
    interface Window {
        Livewire: any;
    }
}

$(function () {
    let officeID: string | null = null;

    $(document).on("submit", "#create-office", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-office-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/superadmin/create-office", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Email is already taken!",
                    confirmButtonColor: "#3a57e8",
                    target: document.body
                });
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#edit-office", function (e) {
        e.preventDefault();
        officeID = $(this).data("id");
        const officeName = $(this).data("name");
        const officeCode = $(this).data("code");
        if (officeID) {
            $("#office-name").val(officeName);
            $("#office-code").val(officeCode);
        }
    });

    $(document).on("submit", "#update-office", function (e) {
        e.preventDefault();

        const formData = new FormData(this as HTMLFormElement);
        formData.append("officeID", officeID || "");
        formData.append("_method", "PATCH");

        const $btn = $(".save-office-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/superadmin/update-office", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("There was an error saving the office.");
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#delete-office", function (e) {
        e.preventDefault();
        officeID = $(this).data("id");
    });

    $(document).on("click", "#delete-office-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        if (!officeID) {
            alert("No office selected to delete!");
            return;
        }

        $btn.prop("disabled", true).text("Deleting...");

        axios
            .delete("/superadmin/delete-office", { data: { officeID } })
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("There was an error deleting the office.");
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Delete");
            });
    });
});
