<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body x-data="baseLayout()" class="h-screen overflow-hidden flex">
    <div class="flex-initial w-[350px]">
        <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="openSidebar()">
            <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
        </span>
        <div class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] overflow-y-auto text-center bg-gray-900">
            <div class="text-gray-100 text-xl">
                <div class="p-2.5 mt-1 flex items-center">
                    <i class="bi bi-app-indicator px-2 py-1 rounded-md bg-blue-600"></i>
                    <h1 class="font-bold text-gray-200 text-[15px] ml-3">LMS Ujian App</h1>
                    <i class="bi bi-x cursor-pointer ml-28 lg:hidden" onclick="openSidebar()"></i>
                </div>
                <div class="my-2 bg-gray-600 h-[1px]"></div>
            </div>
            <div class="p-2.5 flex items-center rounded-md px-4 bg-gray-700 text-white">
                {{-- <i class="bi bi-search text-sm"></i> --}}
                <i class="bi bi-person-circle"></i>
                {{-- <input type="text" placeholder="Search"
                    class="text-[15px] ml-4 w-full bg-transparent focus:outline-none" /> --}}
                <p class="ml-4 bg-transparent">{{ $user->name }}</p>
            </div>
            <div
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="bi bi-house-door-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Dashboard</span>
            </div>
            <div class="my-4 bg-gray-600 h-[1px]"></div>
            <a @click="logout()"
                class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600 text-white">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="text-[15px] ml-4 text-gray-200 font-bold">Logout</span>
            </a>
        </div>
    </div>
    <div class="flex-1 mt-11">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script type="text/javascript">
        function openSidebar() {
            document.querySelector(".sidebar").classList.toggle("hidden");
        }

        const baseLayout = () => {
            return {
                logout() {
                    if (confirm("Apakah Anda Ingin Keluar?")) {
                        const token = localStorage.getItem("web_token");
                        localStorage.removeItem("web_token");
                        window.location.href = "{{ url('/siswa/logout') }}" + "?token=" + token;
                    } else {
                        alert("Batal");
                    }
                }
            }
        }
    </script>
    @stack('script')
</body>

</html>
