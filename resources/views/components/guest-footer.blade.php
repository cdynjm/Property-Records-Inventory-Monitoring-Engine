<footer class="bg-none">

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
            <div class="flex justify-center md:justify-end gap-2 my-3">
                <a href="https://www.facebook.com/ProvincialGovernmentofSouthernLeyte" target="_blank"
                    class="bg-blue-500 text-white p-1 pb-0 rounded">
                    <iconify-icon icon="akar-icons:facebook-fill" width="18" height="18"></iconify-icon>
                </a>
                <a href="#" target="_blank"
                    class="bg-red-500 text-white p-1 pb-0 rounded">
                    <iconify-icon icon="flowbite:youtube-solid" width="18" height="18"></iconify-icon>
                </a>
                <a href="https://southernleyte.gov.ph/" target="_blank"
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
        <div class="md:col-span-2 text-center md:text-left">
            <h5 class="mb-2 font-semibold">Quicklinks</h5>
            <ul>
                <li><a target="_blank" href="https://southernleyte.gov.ph/"
                        class="block pb-1 text-xs hover:underline">Province of Southern Leyte</a></li>
                <li><a target="_blank" href="https://southernleyte.gov.ph/pgso/"
                        class="block pb-1 text-xs hover:underline">Provincial General Services Office</a></li>
                <li><a target="_blank" href="https://jemcdyn.vercel.app/"
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
