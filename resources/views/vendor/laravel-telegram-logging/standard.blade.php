<b>Application:</b> {{ $appName }}
<b>Environment:</b> {{ $appEnv }}
<b>Log Level:</b> <pre>{{ $level_name }}</pre>
<b>Time:</b> {{$datetime->format('Y-m-d H:i:s')}}
<b>Message:</b> <pre>{{$formatted}}</pre>
