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
