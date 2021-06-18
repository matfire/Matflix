<?php

function showAlert($alert)
{
    return <<< "EOT"
        <div class="flex justify-center">
            <div class="w-1/3">
                $alert
            </div>
        </div>
    EOT;
}

function generateAlert($msg, $type = "success")
{
    switch ($type) {
        case 'error':
            return <<< "EOT"
                <div class="block text-sm text-red-600 bg-red-200 border border-red-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                    $msg
                    <button type="button" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove();">
                        <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-red-900" aria-hidden="true" >×</span>
                    </button>
                </div>
                EOT;
            break;
        case "success":
            return <<< "EOT"
            <div class="block text-sm text-white bg-green-400 border border-green-500 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                $msg
                <button type="button" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove();">
                    <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-green-900" aria-hidden="true" >×</span>
                </button>
            </div>
            EOT;
        default:
            break;
    }
}
