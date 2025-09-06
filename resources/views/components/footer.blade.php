<footer class="mt-20">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Left Logo -->
        <div class="flex justify-center md:justify-end">
            <img src="{{ asset('/img/help-desk.png') }}" alt="Help Desk"  class="mt-2 w-[250px]"
                draggable="false" />
        </div>

        <!-- Right Contact -->
        <div class="text-center md:text-left mt-0 md:mt-12">
            <h6 class="mb-1 mt-0 md:mt-4 text-gray-800 flex items-center justify-center md:justify-start text-[15px]">
                Need technical assistance? Chat
                <iconify-icon icon="marketeq:chat-4" width="27" height="27" class="ml-1"></iconify-icon>
            </h6>
            <h3 class="text-green-600 font-bold text-[20px] mb-1">JEMUEL CADAYONA</h3>
            <div class="mb-2">
                <small class="text-[14px]">Software Developer</small>
            </div>
            <hr class="my-2">
            <a href="/messenger/120"
                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded uppercase text-[11px] inline-block mt-2">
                Click to Chat
            </a>
            <div class="mb-4 mt-2">
                <a href="https://jemcdyn.vercel.app/" target="_blank"
                    class="text-gray-600 underline flex items-center justify-center md:justify-start text-[13px]">
                    <iconify-icon icon="logos:webkit" width="25" height="25" class="mr-2"></iconify-icon>
                    https://jemcdyn.vercel.app/
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom row -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mt-6">
        <!-- App Name & Social -->
        <div class="md:col-span-5 text-center md:text-right">
            <h4 class="mb-0 text-lg font-semibold">
                <a href="#" target="_blank" class="hover:underline">{{ env('APP_NAME') }}</a>
            </h4>
            <div>
                <small class="text-[12px]">Property Records & Inventory Monitoring Engine</small>
            </div>

            <span class="text-sm">Online portals</span>
            <div class="flex justify-center md:justify-end gap-2 my-3">
                <a href="https://www.facebook.com/southernleytestateu" target="_blank"
                    class="bg-blue-500 text-white p-1 pb-0 rounded">
                    <iconify-icon icon="akar-icons:facebook-fill" width="18" height="18"></iconify-icon>
                </a>
                <a href="https://youtube.com/c/SouthernLeyteStateUniversity" target="_blank"
                    class="bg-red-500 text-white p-1 pb-0 rounded">
                    <iconify-icon icon="flowbite:youtube-solid" width="18" height="18"></iconify-icon>
                </a>
                <a href="https://www.southernleytestateu.edu.ph/index.php/en/" target="_blank"
                    class="bg-green-500 text-white p-1 pb-0 rounded">
                    <iconify-icon icon="streamline:web-solid" width="18" height="18"></iconify-icon>
                </a>
                <a href="https://gmail.com" target="_blank" class="bg-gray-500 text-white p-1 pb-0 rounded">
                    <iconify-icon icon="mdi:gmail" width="18" height="18"></iconify-icon>
                </a>
            </div>
            <p class="pt-1 text-sm">
                {{ date('Y') }} © Province of Southern Leyte
            </p>
        </div>

        <!-- Quicklinks -->
        <div class="md:col-span-3 text-center md:text-left">
            <h5 class="mb-2 font-semibold">Quicklinks</h5>
            <ul>
                <li><a target="_blank" href="https://southernleyte.gov.ph"
                        class="block pb-1 text-xs hover:underline">Province of Southern Leyte</a></li>
                <li><a target="_blank" href="https://southernleyte.gov.ph"
                        class="block pb-1 text-xs hover:underline">Provincial General Services Office</a></li>
                <li><a target="_blank" href="https://www.facebook.com/slsuccsit"
                        class="block pb-1 text-xs hover:underline">JEM CDYN, Dev.</a></li>
                <li>
                    <hr class="my-2">
                </li>
            </ul>
        </div>

        <!-- Logos -->
        <div class="md:col-span-4 flex justify-center md:justify-start items-center gap-4">
            <a target="_blank" href="https://southernleyte.gov.ph">
                <img class="w-[70px] rounded-full" src="{{ asset('/img/province-logo-official.png') }}"
                    alt="Province Logo">
            </a>
            <a target="_blank" href="https://southernleytestateu.edu.ph">
                <img class="w-[70px] rounded-full border border-gray-300 p-2" src="{{ asset('/img/jemcdyn.png') }}"
                    alt="JEM CDYN Logo">
            </a>
        </div>
    </div>

</footer>
