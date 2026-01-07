<div id="delete-contact-modal" class="hs-overlay hidden fixed inset-0 z-[80] flex items-center justify-center bg-black/50 p-4 overflow-x-hidden overflow-y-auto pointer-events-none">
    <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-100 transition-all w-full max-w-sm m-3 pointer-events-auto shadow-lg rounded-xl">
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm pointer-events-auto dark:bg-slate-900 dark:border-gray-700">
            <div class="p-4 sm:p-7">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                        Confirm Deletion
                    </h3>
                </div>
                
                <p class="text-gray-500 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this contact? This action cannot be undone.
                </p>

                <div class="flex justify-end gap-x-2">
                    <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" data-hs-overlay="#delete-contact-modal">
                        Cancel
                    </button>
                    <button type="button" id="confirm-delete-btn" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                        Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
