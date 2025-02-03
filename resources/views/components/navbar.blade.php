<script>
        document.addEventListener("DOMContentLoaded", function () {
            const dropdownToggle = document.getElementById("dropdownToggle");
            const dropdownMenu = document.getElementById("dropdownMenu");
            
            dropdownToggle.addEventListener("click", function () {
                dropdownMenu.classList.toggle("hidden");
            });
        });
    </script>

    <div class="flex justify-end bg-[#863942] p-4 text-white">
        <div class="relative">
            <button id="dropdownToggle" class="flex items-center space-x-1">
                <span>Ekstrakulikuler</span>
                <span>&#9662;</span>
            </button>
            <div id="dropdownMenu" class="absolute right-0 mt-2 bg-[#A0749F] text-black shadow-md rounded-lg w-48 hidden">
                <a href="#" class="block px-4 py-2 hover:bg-gray-200">--Paskibra--</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-200">--Pramuka--</a>
                <a href="#" class="block px-4 py-2 hover:bg-gray-200">--PMR--</a>
            </div>
        </div>
        <a href="#" class="ml-6">Gallery</a>
        <a href="#" class="ml-6 bg-[#8174A0] px-4 py-2 rounded-lg">LOGIN</a>
    </div>