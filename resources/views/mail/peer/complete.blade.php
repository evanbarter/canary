@component('mail::message')
# New Peer

{{ $peer->name }} ({{ $peer->url }}) has accepted your request to peer and you are now connected.

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

@component('mail::panel')
## You should know...
* Peering is fully mutual. Either of you can break this connection at any time.
* {{ $peer->name }} can now see any posts you have restricted to your peers, and you can see any posts {{ $peer->name }} has restricted.
@endcomponent

@endcomponent
