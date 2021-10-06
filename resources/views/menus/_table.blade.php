<table class="table">
    <thead>
        <tr class="">
            <th class="text-center" width="5%">
                <div>Active</div>
                <div><small>สถานะ</small></div>
            </th>
            <th class="" >
                <div>Title</div>
                <div><small>หัวข้อ</small></div>
            </th>
            <th width="15%">
                <div>Parent Menu</div>
                <div><small>เมนูหลัก</small></div>
            </th>
            <th  class="hidden-sm hidden-xs text-center" width="7%">
                <div>Seq.</div>
                <div><small>ลำดับ</small></div>
            </th>
            <th class="hidden-sm hidden-xs " width="10%">
                <div>URL</div>
                <div><small>ที่อยู่เว็บ</small></div>
            </th>
            <th class="no-sort" width="10%"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($menuTreeAll as $menu)
            @include('menus._tr', ['menu' => $menu, 'noParent' => true])
            @foreach ($menu->children ?? [] as $secondMenu)
                @include('menus._tr', ['menu' => $secondMenu, 'noParent' => false])

                @foreach ($secondMenu->children ?? [] as $thirdMenu)
                    @include('menus._tr', ['menu' => $thirdMenu, 'noParent' => false])
                @endforeach
            @endforeach

        @endforeach
    </tbody>
</table>