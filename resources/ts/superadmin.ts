import $ from "jquery";
import axios from "axios";
declare global {
    interface Window {
        Livewire: any;
    }
}

//OFFICE FUNCTIONS:

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
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Username is already taken";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
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
        const username = $(this).data("username");
        if (officeID) {
            $("#office-name").val(officeName);
            $("#office-code").val(officeCode);
            $("#username").val(username);
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
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[1].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Username is already taken";
                    }
                    $(toast[1]).fadeIn(100);
                    setTimeout(() => $(toast[1]).fadeOut(300), 3000);
                }
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

//UNIT FUNCTIONS:

$(function () {

    let unitID: string | null = null;

    $(document).on("submit", "#create-unit", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-unit-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/superadmin/create-unit", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#edit-unit", function (e) {
        e.preventDefault();
        unitID = $(this).data("id");
        console.log(unitID);
        const unitName = $(this).data("unit");
        if (unitID) {
            $("#unit-name").val(unitName);
        }
    });

    $(document).on("submit", "#update-unit", function (e) {
        e.preventDefault();

        const formData = new FormData(this as HTMLFormElement);
        formData.append("unitID", unitID || "");
        formData.append("_method", "PATCH");

        const $btn = $(".save-unit-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/superadmin/update-unit", formData)
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
               
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#delete-unit", function (e) {
        e.preventDefault();
        unitID = $(this).data("id");
    });

    $(document).on("click", "#delete-unit-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        if (!unitID) {
            alert("No unit selected to delete!");
            return;
        }

        $btn.prop("disabled", true).text("Deleting...");

        axios
            .delete("/superadmin/delete-unit", { data: { unitID } })
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("There was an error deleting the unit.");
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Delete");
            });
    });
});

//ADMIN ACCOUNT FUNCTIONS:

$(function () {

    let adminID: string | null = null;

    $(document).on("submit", "#create-admin", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-admin-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/superadmin/create-admin", formData)
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
                        messageElem.textContent = "Username is already taken";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#edit-admin", function (e) {
        e.preventDefault();
        adminID = $(this).data("id");
        const adminName = $(this).data("name");
        const username = $(this).data("username");
        if (adminID) {
            $("#admin-name").val(adminName);
            $("#username").val(username);
        }
    });

    $(document).on("submit", "#update-admin", function (e) {
        e.preventDefault();

        const formData = new FormData(this as HTMLFormElement);
        formData.append("adminID", adminID || "");
        formData.append("_method", "PATCH");

        const $btn = $(".save-admin-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/superadmin/update-admin", formData)
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
                        messageElem.textContent = "Username is already taken";
                    }
                    $(toast[1]).fadeIn(100);
                    setTimeout(() => $(toast[1]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#delete-admin", function (e) {
        e.preventDefault();
        adminID = $(this).data("id");
    });

    $(document).on("click", "#delete-admin-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        if (!adminID) {
            alert("No admin selected to delete!");
            return;
        }

        $btn.prop("disabled", true).text("Deleting...");

        axios
            .delete("/superadmin/delete-admin", { data: { adminID } })
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("There was an error deleting the admin.");
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Delete");
            });
    });
});