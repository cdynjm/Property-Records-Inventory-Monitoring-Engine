import "iconify-icon";
import "./admin";
import "./office";
import "./superadmin";

import $ from "jquery";
import axios from "axios";

$(function () {
    $(document).on("click", "#log-out", function (e) {
        e.preventDefault();

        axios
            .post("/logout")
            .then((response) => {
                window.Livewire.navigate(window.location.pathname);
            })
            .catch((error) => {});
    });
});

document.addEventListener("click", function (e) {
    const target = e.target as Element | null;
    if (!target) return;
    const link = target.closest(".livewire-nav-link");
    if (link) {
        e.preventDefault();
        const url = link.getAttribute("data-url");
        if (url) {
            window.Livewire.navigate(url);
        }
    }
});
