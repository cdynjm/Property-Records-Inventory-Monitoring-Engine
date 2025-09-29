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
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
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
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
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
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
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
        let position = $(this).find(":selected").data("position") || "";
        $("#received-from-position").val(position);
    });
});

//ICS FUNCTIONS:

$(function () {
    $(document).on("submit", "#create-ics-form", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-ics-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/create-ics", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
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

    $(document).on("submit", "#update-ics-form", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        formData.append("_method", "PATCH");
        const $btn = $(".save-ics-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/update-ics", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
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

//SEARCH RECEIVED BY FUNCTIONS:

$(function () {
    $(document).on("input", "#received-by", function () {
        const query = $(this).val();

        const $results = $("#receivedByResults");
        $results.empty().show();
        $results.append(
            `<div class="p-2 text-gray-500 italic">Searching...</div>`
        );

        if (query.length < 3) {
            $("#receivedByResults").empty().hide();
            $("#received-by-id").val("");
            $("#received-by-position").val("");
            return;
        }

        axios
            .get("/admin/search-received-by", { params: { search: query } })
            .then((response: any) => {
                const data = response.data;
                $results.empty();

                if (data.length === 0) {
                    $results.hide();
                } else {
                    data.forEach((item: any) => {
                        $results.append(`
                        <div class="p-2 cursor-pointer hover:bg-gray-100 w-full" 
                             data-id="${item.encrypted_id}" 
                             data-name="${item.name}"
                             data-position="${item.position || ""}">
                            ${item.name}
                        </div>
                    `);
                    });
                    $results.show();
                }
            })
            .catch((error) => {
                console.error("Search error:", error);
            });
    });

    $(document).on("click", "#receivedByResults div", function () {
        const name = $(this).data("name");
        const id = $(this).data("id");
        const position = $(this).data("position");

        $("#received-by").val(name);
        $("#received-by-id").val(id);

        if (position) {
            $("#received-by-position").val(position);
        } else {
            $("#received-by-position").val("");
        }

        $("#receivedByResults").hide();
    });

    $(document).on("click", function (e) {
        if (!$(e.target).closest("#received-by, #receivedByResults").length) {
            $("#receivedByResults").hide();
        }
    });
});

//SEARCH ICS RECORDS FUNCTIONS:

$(function () {
    $(document).on("click", "#search-records", function (e) {
        e.preventDefault();
        const search = $('#search-keyword').val();
        const formData = new FormData();
        formData.append('search', search as string)
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/admin/search", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in searching";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false);
            });
    });

    $(document).on("click", "#clear-keyword", function (e) {
        e.preventDefault();
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/admin/search-clear")
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in clearing";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false);
            });
    });

    $(document).on("click", "#search-year-records", function (e) {
        e.preventDefault();
        const year = $('#search-year').val();
        const formData = new FormData();
        formData.append('year', year as string)
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/admin/year", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in searching";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false);
            });
    });

    $(document).on("click", "#clear-year", function (e) {
        e.preventDefault();
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/admin/year-clear")
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in clearing";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false);
            });
    });
});

//SEARCH RECEIVER FUNCTIONS;

$(function () {
    $(document).on("click", "#search-receiver-records", function (e) {
        e.preventDefault();
        const search = $('#search-receiver').val();
        const formData = new FormData();
        formData.append('search', search as string)
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/admin/search-receiver", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in searching";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false);
            });
    });

    $(document).on("click", "#clear-receiver", function (e) {
        e.preventDefault();
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/admin/clear-receiver")
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in clearing";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false);
            });
    });
});

//ACCOUNT FUNCTIONS:

$(function () {

    let accountID: string | null = null;

    $(document).on("submit", "#create-account", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-account-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/create-accounts-code", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in saving Account Code";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#edit-account", function (e) {
        e.preventDefault();
        accountID = $(this).data("id");
        const propertyCode = $(this).data("property-code");
        const propertySubCode = $(this).data("property-sub-code");
        const description = $(this).data("description");

        console.log(accountID)
        console.log(propertyCode)
        if (accountID) {
            $("#property-code").val(propertyCode);
            $("#property-sub-code").val(propertySubCode);
            $("#description").val(description);
        }
    });

    $(document).on("submit", "#update-account", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        formData.append("accountID", accountID || "");
        formData.append("_method", "PATCH");

        const $btn = $(".save-account-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/update-accounts-code", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in saving Account Code";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("click", "#delete-account", function (e) {
        e.preventDefault();
        accountID = $(this).data("id");
    });

    $(document).on("click", "#delete-account-btn", function (e) {
        e.preventDefault();
        const $btn = $(this);
        if (!accountID) {
            alert("No account selected to delete!");
            return;
        }

        $btn.prop("disabled", true).text("Deleting...");

        axios
            .delete("/admin/delete-accounts-code", { data: { accountID } })
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                console.error("Error:", error);
                alert("There was an error deleting the account.");
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Delete");
            });
    });
});

//ARE FUNCTIONS:

$(function () {
    $(document).on("submit", "#create-are-form", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        const $btn = $(".save-are-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/create-are", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in saving ARE";
                    }
                    $(toast[0]).fadeIn(100);
                    setTimeout(() => $(toast[0]).fadeOut(300), 3000);
                }
            })
            .finally(() => {
                $btn.prop("disabled", false).text("Save changes");
            });
    });

    $(document).on("submit", "#update-are-form", function (e) {
        e.preventDefault();
        const formData = new FormData(this as HTMLFormElement);
        formData.append("_method", "PATCH");
        const $btn = $(".save-are-btn");
        $btn.prop("disabled", true).text("Saving...");

        axios
            .post("/admin/update-are", formData)
            .then((response: any) => {
                window.Livewire.navigate(window.location.pathname) as any;
            })
            .catch((error) => {
                const toast = document.getElementsByClassName("toast-error");

                if (toast.length > 0) {
                    const messageElem = toast[0].querySelector(
                        ".toast-error-message"
                    );
                    if (messageElem) {
                        messageElem.textContent = "Error in saving ARE";
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