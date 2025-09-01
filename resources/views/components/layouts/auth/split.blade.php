<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen flex flex-col bg-gray-50 antialiased">
        
        <!-- Main container -->
        <div class="flex flex-1 items-center justify-center px-4 py-12">
            <div class="bg-white shadow-md rounded-lg flex flex-col lg:flex-row overflow-hidden w-full max-w-5xl">
                
                <!-- Left Illustration -->
                <div class="hidden lg:flex w-1/2 bg-gray-50 items-center justify-center p-8">
                    <img src="{{ asset('/img/help-desk.png') }}" 
                         alt="Login Illustration"
                         draggable="false"
                         class="max-h-[400px] object-contain">
                </div>

                <!-- Right Login Form -->
                <div class="w-full lg:w-1/2 p-10 md:p-15 flex flex-col justify-center">
                    <div>
                        {{ $slot }}
                    </div>

                    <div class="mt-6 text-center text-xs text-gray-500">
                        Effortlessly <span class="font-bold text-green-600">track your properties and inventories</span> ensuring 
                        efficiency and reliability at every step!
                    </div>
                </div>
            </div>
        </div>

        

        @fluxScripts
    </body>
</html>
