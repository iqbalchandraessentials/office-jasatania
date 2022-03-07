@component('mail::message')
# Terima kasih telah mengajukan

@foreach($transaction as $link)

Kami hendak memberikan informasi bahwa Nomor PK : {{$link->no_pk}}<br>

masih menunggu kami setujui <br>

Silahkan klik tombol dibawah untuk melihat rincian pengajuan

@component('mail::button', ['url' => 'http://laravel9-banksumut.test/api/show/'.$link->no_pk ])
Lihat status
@endcomponent

Atas perhatiannya diucapkan Terima kasih

@endforeach

Regards,
Jastan,<br>
{{ config('app.name') }}
@endcomponent