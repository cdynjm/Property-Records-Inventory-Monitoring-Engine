import $ from "jquery";
import axios from "axios";
declare global {
    interface Window {
        Livewire: any;
    }
}

//SEARCH RECORDS FUNCTIONS:

$(function () {

    $(document).on("click", "#office-search-records", function (e) {
        e.preventDefault();
        const search = $('#search-keyword').val();
        const formData = new FormData();
        formData.append('search', search as string)
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/office/search", formData)
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

    $(document).on("click", "#office-clear-keyword", function (e) {
        e.preventDefault();
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/office/search-clear")
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

    $(document).on("click", "#office-search-year-records", function (e) {
        e.preventDefault();
        const year = $('#search-year').val();
        const formData = new FormData();
        formData.append('year', year as string)
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/office/year", formData)
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

    $(document).on("click", "#office-clear-year", function (e) {
        e.preventDefault();
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/office/year-clear")
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

    $(document).on("click", "#office-search-rpcppe-records", function (e) {
        e.preventDefault();
        const year = $('#office-rpcppe-year').val();
        const accountsCode = $('#office-rpcppe-accounts-code').val();

        const formData = new FormData();
        formData.append('year', year as string)
        formData.append('accountsCode', accountsCode as string)
        const $btn = $(this);
        $btn.prop("disabled", true);

        axios
            .post("/office/search-rpcppe", formData)
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
});
