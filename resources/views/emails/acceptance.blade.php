@component('mail::message')
# Hello!
Terima kasih telah mengajukan <br>
Kami hendak memberikan informasi bahwa Nomor PK : {{$item->no_pk}} <br>
{{$pesan}} <br>
@component('mail::button', ['url' => 'http://laravel9-banksumut.test/api/cetak/'.$item->id])
Print Polis
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent