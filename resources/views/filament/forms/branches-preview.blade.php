<div class="rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-2">
            <x-heroicon-o-building-storefront class="w-4 h-4 text-gray-500" />
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                Danh sách chi nhánh
            </span>
        </div>
        <a
            href="{{ route('filament.admin.resources.branches.index') }}"
            class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-primary-500 transition"
        >
            <x-heroicon-m-arrow-top-right-on-square class="w-3.5 h-3.5" />
            Quản lý chi nhánh
        </a>
    </div>

    @php
        $branches = \App\Models\Branch::orderBy('sort_order')->orderBy('is_main', 'desc')->get();
    @endphp

    @if ($branches->isEmpty())
        <div class="px-4 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
            Chưa có chi nhánh nào. Nhấn "Quản lý chi nhánh" để thêm mới.
        </div>
    @else
        <table class="w-full text-sm divide-y divide-gray-100 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-800/30 text-left text-xs font-semibold text-gray-500 uppercase">
                <tr>
                    <th class="px-4 py-2">Tên chi nhánh</th>
                    <th class="px-4 py-2">Địa chỉ</th>
                    <th class="px-4 py-2">Điện thoại</th>
                    <th class="px-4 py-2 text-center">Chính</th>
                    <th class="px-4 py-2 text-center">Trạng thái</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach ($branches as $branch)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition">
                        <td class="px-4 py-2.5 font-medium text-gray-800 dark:text-gray-200">
                            {{ $branch->name }}
                        </td>
                        <td class="px-4 py-2.5 text-gray-600 dark:text-gray-400 max-w-xs truncate">
                            {{ $branch->address ?: '—' }}
                        </td>
                        <td class="px-4 py-2.5 text-gray-600 dark:text-gray-400">
                            {{ $branch->phone ?: '—' }}
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if ($branch->is_main)
                                <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-700">
                                    <x-heroicon-m-star class="w-3 h-3"/>
                                    Chính
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            @if ($branch->is_active)
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Hiện
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                    Ẩn
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
