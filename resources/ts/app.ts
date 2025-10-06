import "iconify-icon";

import './components/chart'

import "./admin";
import "./office";
import "./superadmin";

import $ from "jquery";
import axios from "axios";

$(function () {
    $(document).on("click", "#log-out", function (e) {
        e.preventDefault();
        localStorage.removeItem("visitedPages");
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

document.addEventListener("livewire:navigated", () => {
    setTimeout(() => {
        const loader = document.getElementById("skeleton-loader");
        if (loader) {
            loader.style.opacity as string;
            loader.style.transition = "opacity 0.5s ease";
            setTimeout(() => loader.remove(), 250);
        }
    }, 250);
});

window.addEventListener("load", () => {
    setTimeout(() => {
        const loader = document.getElementById("skeleton-loader");
        if (loader) {
            loader.style.opacity as string;
            loader.style.transition = "opacity 0.5s ease";
            setTimeout(() => loader.remove(), 250);
        }
    }, 250);
});

interface SkeletonEvent extends Event {
    type: "DOMContentLoaded" | "livewire:navigated" | string;
}

function handleSkeleton(event: SkeletonEvent): void {
    const loader: HTMLElement | null = document.getElementById("skeleton-loader");
    const currentUrl: string = window.location.pathname;

    if (currentUrl === "/login" || !loader) {
        localStorage.clear();
        sessionStorage.clear();
        return;
    }

    let visitedPages: string[] = JSON.parse(localStorage.getItem("visitedPages") || "[]");
    const fromLivewire: boolean = event.type === "livewire:navigated";

    if (!visitedPages.includes(currentUrl)) {
        visitedPages.push(currentUrl);

        if (visitedPages.length > 100) {
            visitedPages = visitedPages.slice(visitedPages.length - 100);
        }

        localStorage.setItem("visitedPages", JSON.stringify(visitedPages));
        setTimeout((): void => {
            loader.classList.add("hidden");
        }, 1000);
    } else {
        if (fromLivewire) {
            loader.classList.add("hidden");
        } else {
            setTimeout((): void => {
                loader.classList.add("hidden");
            }, 1000);
        }
    }
}

document.addEventListener("DOMContentLoaded", handleSkeleton);
document.addEventListener("livewire:navigated", handleSkeleton);

