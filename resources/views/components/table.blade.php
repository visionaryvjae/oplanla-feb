<div class="flex w-full">
    <div class="w-full overflow-hidden  rounded-lg">
        <table class="w-full hidden md:table">
            <thead class="bg-gray-100 rounded">
                <tr>
                    @for ($i = 0; $i < count($tblHeaders); $i++)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $tblHeaders[$i] }}</th>
                    @endfor
                </tr>
            </thead>

            <tbody>
                @forelse ($items as $item)
                    <tr class="hover:bg-gray-50 cursor-pointer">
                        @for ($i = 0; $i < count($tblRows); $i++)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-b border-gray-200">{{ $item->{$tblRows[$i]} }}</td>
                        @endfor
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">You have no active maintenance requests.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>