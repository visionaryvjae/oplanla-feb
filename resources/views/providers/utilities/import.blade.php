@extends('layouts.providers')

@section('content')
<div class="md:max-w-6xl md:px-0 px-4 w-full  mx-auto py-10">
    <div class="mb-8 flex md:flex-row flex-col justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Utility Billing Center</h1>
            <p class="text-gray-500">Import Motla readings to generate tenant invoices.</p>
        </div>
        <div class="bg-[#ad68e4] text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm md:mt-0 mt-4">
            Current Cycle: February 2026
        </div>
    </div>

    <form action="{{ route('provider.utilities.analyze') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="bg-white rounded-2xl p-10 border-2 border-dashed border-[#68e4ad]/30 text-center mb-2">
            <div class="w-20 h-20 bg-[#68e4ad]/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-file-csv text-3xl text-[#68e4ad]"></i>
            </div>
            <h2 class="text-xl font-bold mb-2 text-gray-800">Upload Motla CSV</h2>
            <p class="text-gray-500 mb-6 max-w-sm mx-auto">Drop your latest meter export file here. OPLANLA will automatically match readings to your rooms.</p>
            
            <input type="file" id="motla_csv" name="motla_file" accept=".csv" required>
            <label for="motla_csv" class="cursor-pointer bg-[#68e4ad] text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:translate-y-[-2px] transition active:scale-95 inline-block">
                Select Motla File
            </label>
        </div>
        <div class="flex w-full items-center justify-end mb-4">
            <button type="submit" class="bg-[#ad68e4] text-white px-4 py-2 rounded-sm font-black shadow-lg hover:shadow-purple-200 transition flex items-center">
                <i class="fa-solid fa-upload"></i> Upload & Analyze
            </button>
        </div>
    </form>

</div>
@endsection