<x-tests.app>
    <x-slot name="header">
        ヘッダー１
    </x-slot>

    test1

    <x-tests.card title="タイトル1" content="本文1" :message="$message" />
    <x-tests.card title="タイトル２" />
    <x-tests.card title="CSSを親側で変更したい" class="bg-red-300" />


</x-tests.app>
