@extends('admin.layout.app')
@section('title', 'Company')
@push('style')
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">        
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-4">{{ __('Company') }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Preference') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('Company') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4 border-left-dark shadow-lg">
                        <div class="card-header">
                            <h6 class="card-title mb-0 flex-grow-1 text-primary">Customize Your Application</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.preference.company.update') }}" method="POST">
                                @csrf
                                <div class="form-group mb-3">
                                    <label for="app_name">App Name</label>
                                    <input type="text" name="APP_NAME" id="app_name" class="form-control"
                                        value="{{ config('app.name') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_host">App Host</label>
                                    <input type="url" name="APP_URL" id="app_host" class="form-control"
                                        value="{{ config('app.url') }}">
                                </div>

                                <div class="form-group  mb-3">
                                    <label for="app_timezone">Default TimeZoe</label>
                                    <select name="APP_TIMEZONE" id="app_timezone" class="form-control">
                                        <option value="Pacific/Midway"
                                            {{ config('app.timezone') == 'Pacific/Midway' ? 'selected' : '' }}>(GMT-11:00)
                                            Midway
                                            Island, Samoa</option>
                                        <option value="America/Adak"
                                            {{ config('app.timezone') == 'America/Adak' ? 'selected' : '' }}>(GMT-10:00)
                                            Hawaii-Aleutian</option>
                                        <option value="Etc/GMT+10"
                                            {{ config('app.timezone') == 'Etc/GMT+10' ? 'selected' : '' }}>(GMT-10:00) Hawaii
                                        </option>
                                        <option value="Pacific/Marquesas"
                                            {{ config('app.timezone') == 'Pacific/Marquesas' ? 'selected' : '' }}>(GMT-09:30)
                                            Marquesas Islands</option>
                                        <option value="Pacific/Gambier"
                                            {{ config('app.timezone') == 'Pacific/Gambier' ? 'selected' : '' }}>(GMT-09:00)
                                            Gambier Islands</option>
                                        <option value="America/Anchorage"
                                            {{ config('app.timezone') == 'America/Anchorage' ? 'selected' : '' }}>(GMT-09:00)
                                            Alaska</option>
                                        <option value="America/Ensenada"
                                            {{ config('app.timezone') == 'America/Ensenada' ? 'selected' : '' }}>(GMT-08:00)
                                            Tijuana, Baja California</option>
                                        <option value="Etc/GMT+8"
                                            {{ config('app.timezone') == 'Etc/GMT+8' ? 'selected' : '' }}>
                                            (GMT-08:00) Pitcairn Islands</option>
                                        <option value="America/Los_Angeles"
                                            {{ config('app.timezone') == 'America/Los_Angeles' ? 'selected' : '' }}>
                                            (GMT-08:00)
                                            Pacific Time (US & Canada)</option>
                                        <option value="America/Denver"
                                            {{ config('app.timezone') == 'America/Denver' ? 'selected' : '' }}>(GMT-07:00)
                                            Mountain Time (US & Canada)</option>
                                        <option value="America/Chihuahua"
                                            {{ config('app.timezone') == 'America/Chihuahua' ? 'selected' : '' }}>(GMT-07:00)
                                            Chihuahua, La Paz, Mazatlan</option>
                                        <option value="America/Dawson_Creek"
                                            {{ config('app.timezone') == 'America/Dawson_Creek' ? 'selected' : '' }}>
                                            (GMT-07:00)
                                            Arizona</option>
                                        <option value="America/Belize"
                                            {{ config('app.timezone') == 'America/Belize' ? 'selected' : '' }}>(GMT-06:00)
                                            Saskatchewan, Central America</option>
                                        <option value="America/Cancun"
                                            {{ config('app.timezone') == 'America/Cancun' ? 'selected' : '' }}>(GMT-06:00)
                                            Guadalajara, Mexico City, Monterrey</option>
                                        <option value="Chile/EasterIsland"
                                            {{ config('app.timezone') == 'Chile/EasterIsland' ? 'selected' : '' }}>
                                            (GMT-06:00)
                                            Easter Island</option>
                                        <option value="America/Chicago"
                                            {{ config('app.timezone') == 'America/Chicago' ? 'selected' : '' }}>(GMT-06:00)
                                            Central Time (US & Canada)</option>
                                        <option value="America/New_York"
                                            {{ config('app.timezone') == 'America/New_York' ? 'selected' : '' }}>(GMT-05:00)
                                            Eastern Time (US & Canada)</option>
                                        <option value="America/Havana"
                                            {{ config('app.timezone') == 'America/Havana' ? 'selected' : '' }}>(GMT-05:00)
                                            Cuba
                                        </option>
                                        <option value="America/Bogota"
                                            {{ config('app.timezone') == 'America/Bogota' ? 'selected' : '' }}>(GMT-05:00)
                                            Bogota, Lima, Quito, Rio Branco</option>
                                        <option value="America/Caracas"
                                            {{ config('app.timezone') == 'America/Caracas' ? 'selected' : '' }}>(GMT-04:30)
                                            Caracas</option>
                                        <option value="America/Santiago"
                                            {{ config('app.timezone') == 'America/Santiago' ? 'selected' : '' }}>(GMT-04:00)
                                            Santiago</option>
                                        <option value="America/La_Paz"
                                            {{ config('app.timezone') == 'America/La_Paz' ? 'selected' : '' }}>(GMT-04:00) La
                                            Paz
                                        </option>
                                        <option value="Atlantic/Stanley"
                                            {{ config('app.timezone') == 'Atlantic/Stanley' ? 'selected' : '' }}>(GMT-04:00)
                                            Faukland Islands</option>
                                        <option value="America/Campo_Grande"
                                            {{ config('app.timezone') == 'America/Campo_Grande' ? 'selected' : '' }}>
                                            (GMT-04:00)
                                            Brazil</option>
                                        <option value="America/Goose_Bay"
                                            {{ config('app.timezone') == 'America/Goose_Bay' ? 'selected' : '' }}>(GMT-04:00)
                                            Atlantic Time (Goose Bay)</option>
                                        <option value="America/Glace_Bay"
                                            {{ config('app.timezone') == 'America/Glace_Bay' ? 'selected' : '' }}>(GMT-04:00)
                                            Atlantic Time (Canada)</option>
                                        <option value="America/St_Johns"
                                            {{ config('app.timezone') == 'America/St_Johns' ? 'selected' : '' }}>(GMT-03:30)
                                            Newfoundland</option>
                                        <option value="America/Araguaina"
                                            {{ config('app.timezone') == 'America/Araguaina' ? 'selected' : '' }}>(GMT-03:00)
                                            UTC-3</option>
                                        <option value="America/Montevideo"
                                            {{ config('app.timezone') == 'America/Montevideo' ? 'selected' : '' }}>
                                            (GMT-03:00)
                                            Montevideo</option>
                                        <option value="America/Miquelon"
                                            {{ config('app.timezone') == 'America/Miquelon' ? 'selected' : '' }}>(GMT-03:00)
                                            Miquelon, St. Pierre</option>
                                        <option value="America/Godthab"
                                            {{ config('app.timezone') == 'America/Godthab' ? 'selected' : '' }}>(GMT-03:00)
                                            Greenland</option>
                                        <option value="America/Argentina/Buenos_Aires"
                                            {{ config('app.timezone') == 'America/Argentina/Buenos_Aires' ? 'selected' : '' }}>
                                            (GMT-03:00) Buenos Aires</option>
                                        <option value="America/Sao_Paulo"
                                            {{ config('app.timezone') == 'America/Sao_Paulo' ? 'selected' : '' }}>(GMT-03:00)
                                            Brasilia</option>
                                        <option value="America/Noronha"
                                            {{ config('app.timezone') == 'America/Noronha' ? 'selected' : '' }}>(GMT-02:00)
                                            Mid-Atlantic</option>
                                        <option value="Atlantic/Cape_Verde"
                                            {{ config('app.timezone') == 'Atlantic/Cape_Verde' ? 'selected' : '' }}>
                                            (GMT-01:00)
                                            Cape Verde Is.</option>
                                        <option value="Atlantic/Azores"
                                            {{ config('app.timezone') == 'Atlantic/Azores' ? 'selected' : '' }}>(GMT-01:00)
                                            Azores</option>
                                        <option value="Europe/Belfast"
                                            {{ config('app.timezone') == 'Europe/Belfast' ? 'selected' : '' }}>(GMT)
                                            Greenwich
                                            Mean Time : Belfast</option>
                                        <option value="Europe/Dublin"
                                            {{ config('app.timezone') == 'Europe/Dublin' ? 'selected' : '' }}>(GMT) Greenwich
                                            Mean Time : Dublin</option>
                                        <option value="Europe/Lisbon"
                                            {{ config('app.timezone') == 'Europe/Lisbon' ? 'selected' : '' }}>(GMT) Greenwich
                                            Mean Time : Lisbon</option>
                                        <option value="Europe/London"
                                            {{ config('app.timezone') == 'Europe/London' ? 'selected' : '' }}>(GMT) Greenwich
                                            Mean Time : London</option>
                                        <option value="Africa/Abidjan"
                                            {{ config('app.timezone') == 'Africa/Abidjan' ? 'selected' : '' }}>(GMT)
                                            Monrovia,
                                            Reykjavik</option>
                                        <option value="Europe/Amsterdam"
                                            {{ config('app.timezone') == 'Europe/Amsterdam' ? 'selected' : '' }}>(GMT+01:00)
                                            Amsterdam, Berlin, Bern, Rome, Stockholm,
                                            Vienna
                                        </option>
                                        <option value="Europe/Belgrade"
                                            {{ config('app.timezone') == 'Europe/Belgrade' ? 'selected' : '' }}>(GMT+01:00)
                                            Belgrade, Bratislava, Budapest, Ljubljana,
                                            Prague
                                        </option>
                                        <option value="Europe/Brussels"
                                            {{ config('app.timezone') == 'Europe/Brussels' ? 'selected' : '' }}>(GMT+01:00)
                                            Brussels, Copenhagen, Madrid, Paris</option>
                                        <option value="Africa/Algiers"
                                            {{ config('app.timezone') == 'Africa/Algiers' ? 'selected' : '' }}>(GMT+01:00)
                                            West
                                            Central Africa</option>
                                        <option value="Africa/Windhoek"
                                            {{ config('app.timezone') == 'Africa/Windhoek' ? 'selected' : '' }}>(GMT+01:00)
                                            Windhoek</option>
                                        <option value="Asia/Beirut"
                                            {{ config('app.timezone') == 'Asia/Beirut' ? 'selected' : '' }}>(GMT+02:00)
                                            Beirut
                                        </option>
                                        <option value="Africa/Cairo"
                                            {{ config('app.timezone') == 'Africa/Cairo' ? 'selected' : '' }}>(GMT+02:00)
                                            Cairo
                                        </option>
                                        <option value="Asia/Gaza"
                                            {{ config('app.timezone') == 'Asia/Gaza' ? 'selected' : '' }}>
                                            (GMT+02:00) Gaza</option>
                                        <option value="Africa/Blantyre"
                                            {{ config('app.timezone') == 'Africa/Blantyre' ? 'selected' : '' }}>(GMT+02:00)
                                            Harare, Pretoria</option>
                                        <option value="Asia/Jerusalem"
                                            {{ config('app.timezone') == 'Asia/Jerusalem' ? 'selected' : '' }}>(GMT+02:00)
                                            Jerusalem</option>
                                        <option value="Europe/Minsk"
                                            {{ config('app.timezone') == 'Europe/Minsk' ? 'selected' : '' }}>(GMT+02:00)
                                            Minsk
                                        </option>
                                        <option value="Asia/Damascus"
                                            {{ config('app.timezone') == 'Asia/Damascus' ? 'selected' : '' }}>(GMT+02:00)
                                            Syria
                                        </option>
                                        <option value="Europe/Moscow"
                                            {{ config('app.timezone') == 'Europe/Moscow' ? 'selected' : '' }}>(GMT+03:00)
                                            Moscow,
                                            St. Petersburg, Volgograd</option>
                                        <option value="Africa/Addis_Ababa"
                                            {{ config('app.timezone') == 'Africa/Addis_Ababa' ? 'selected' : '' }}>
                                            (GMT+03:00)
                                            Nairobi</option>
                                        <option value="Asia/Tehran"
                                            {{ config('app.timezone') == 'Asia/Tehran' ? 'selected' : '' }}>(GMT+03:30)
                                            Tehran
                                        </option>
                                        <option value="Asia/Dubai"
                                            {{ config('app.timezone') == 'Asia/Dubai' ? 'selected' : '' }}>(GMT+04:00) Abu
                                            Dhabi,
                                            Muscat</option>
                                        <option value="Asia/Yerevan"
                                            {{ config('app.timezone') == 'Asia/Yerevan' ? 'selected' : '' }}>(GMT+04:00)
                                            Yerevan
                                        </option>
                                        <option value="Asia/Kabul"
                                            {{ config('app.timezone') == 'Asia/Kabul' ? 'selected' : '' }}>(GMT+04:30) Kabul
                                        </option>
                                        <option value="Asia/Yekaterinburg"
                                            {{ config('app.timezone') == 'Asia/Yekaterinburg' ? 'selected' : '' }}>
                                            (GMT+05:00)
                                            Ekaterinburg</option>
                                        <option value="Asia/Tashkent"
                                            {{ config('app.timezone') == 'Asia/Tashkent' ? 'selected' : '' }}>(GMT+05:00)
                                            Tashkent</option>
                                        <option value="Asia/Kolkata"
                                            {{ config('app.timezone') == 'Asia/Kolkata' ? 'selected' : '' }}>(GMT+05:30)
                                            Chennai,
                                            Kolkata, Mumbai, New Delhi</option>
                                        <option value="Asia/Katmandu"
                                            {{ config('app.timezone') == 'Asia/Katmandu' ? 'selected' : '' }}>(GMT+05:45)
                                            Kathmandu</option>
                                        <option value="Asia/Dhaka"
                                            {{ config('app.timezone') == 'Asia/Dhaka' ? 'selected' : '' }}>
                                            (GMT+06:00) Astana, Dhaka</option>
                                        <option value="Asia/Novosibirsk"
                                            {{ config('app.timezone') == 'Asia/Novosibirsk' ? 'selected' : '' }}>(GMT+06:00)
                                            Novosibirsk</option>
                                        <option value="Asia/Rangoon"
                                            {{ config('app.timezone') == 'Asia/Rangoon' ? 'selected' : '' }}>(GMT+06:30)
                                            Yangon
                                            (Rangoon)</option>
                                        <option value="Asia/Bangkok"
                                            {{ config('app.timezone') == 'Asia/Bangkok' ? 'selected' : '' }}>(GMT+07:00)
                                            Bangkok,
                                            Hanoi, Jakarta</option>
                                        <option value="Asia/Krasnoyarsk"
                                            {{ config('app.timezone') == 'Asia/Krasnoyarsk' ? 'selected' : '' }}>(GMT+07:00)
                                            Krasnoyarsk</option>
                                        <option value="Asia/Hong_Kong"
                                            {{ config('app.timezone') == 'Asia/Hong_Kong' ? 'selected' : '' }}>(GMT+08:00)
                                            Beijing, Chongqing, Hong Kong, Urumqi</option>
                                        <option value="Asia/Irkutsk"
                                            {{ config('app.timezone') == 'Asia/Irkutsk' ? 'selected' : '' }}>(GMT+08:00)
                                            Irkutsk,
                                            Ulaan Bataar</option>
                                        <option value="Australia/Perth"
                                            {{ config('app.timezone') == 'Australia/Perth' ? 'selected' : '' }}>(GMT+08:00)
                                            Perth
                                        </option>
                                        <option value="Australia/Eucla"
                                            {{ config('app.timezone') == 'Australia/Eucla' ? 'selected' : '' }}>(GMT+08:45)
                                            Eucla
                                        </option>
                                        <option value="Asia/Tokyo"
                                            {{ config('app.timezone') == 'Asia/Tokyo' ? 'selected' : '' }}>(GMT+09:00) Osaka,
                                            Sapporo, Tokyo</option>
                                        <option value="Asia/Seoul"
                                            {{ config('app.timezone') == 'Asia/Seoul' ? 'selected' : '' }}>(GMT+09:00) Seoul
                                        </option>
                                        <option value="Asia/Yakutsk"
                                            {{ config('app.timezone') == 'Asia/Yakutsk' ? 'selected' : '' }}>(GMT+09:00)
                                            Yakutsk
                                        </option>
                                        <option value="Australia/Adelaide"
                                            {{ config('app.timezone') == 'Australia/Adelaide' ? 'selected' : '' }}>
                                            (GMT+09:30)
                                            Adelaide</option>
                                        <option value="Australia/Darwin"
                                            {{ config('app.timezone') == 'Australia/Darwin' ? 'selected' : '' }}>(GMT+09:30)
                                            Darwin</option>
                                        <option value="Australia/Brisbane"
                                            {{ config('app.timezone') == 'Australia/Brisbane' ? 'selected' : '' }}>
                                            (GMT+10:00)
                                            Brisbane</option>
                                        <option value="Australia/Hobart"
                                            {{ config('app.timezone') == 'Australia/Hobart' ? 'selected' : '' }}>(GMT+10:00)
                                            Hobart</option>
                                        <option value="Asia/Vladivostok"
                                            {{ config('app.timezone') == 'Asia/Vladivostok' ? 'selected' : '' }}>(GMT+10:00)
                                            Vladivostok</option>
                                        <option value="Australia/Lord_Howe"
                                            {{ config('app.timezone') == 'Australia/Lord_Howe' ? 'selected' : '' }}>
                                            (GMT+10:30)
                                            Lord Howe Island</option>
                                        <option value="Etc/GMT-11"
                                            {{ config('app.timezone') == 'Etc/GMT-11' ? 'selected' : '' }}>(GMT+11:00)
                                            Solomon
                                            Is., New Caledonia</option>
                                        <option value="Asia/Magadan"
                                            {{ config('app.timezone') == 'Asia/Magadan' ? 'selected' : '' }}>(GMT+11:00)
                                            Magadan
                                        </option>
                                        <option value="Pacific/Norfolk"
                                            {{ config('app.timezone') == 'Pacific/Norfolk' ? 'selected' : '' }}>(GMT+11:30)
                                            Norfolk Island</option>
                                        <option value="Asia/Anadyr"
                                            {{ config('app.timezone') == 'Asia/Anadyr' ? 'selected' : '' }}>(GMT+12:00)
                                            Anadyr,
                                            Kamchatka</option>
                                        <option value="Pacific/Auckland"
                                            {{ config('app.timezone') == 'Pacific/Auckland' ? 'selected' : '' }}>(GMT+12:00)
                                            Auckland, Wellington</option>
                                        <option value="Etc/GMT-12"
                                            {{ config('app.timezone') == 'Etc/GMT-12' ? 'selected' : '' }}>(GMT+12:00) Fiji,
                                            Kamchatka, Marshall Is.</option>
                                        <option value="Pacific/Chatham"
                                            {{ config('app.timezone') == 'Pacific/Chatham' ? 'selected' : '' }}>(GMT+12:45)
                                            Chatham Islands</option>
                                        <option value="Pacific/Tongatapu"
                                            {{ config('app.timezone') == 'Pacific/Tongatapu' ? 'selected' : '' }}>(GMT+13:00)
                                            Nuku'alofa</option>
                                        <option value="Pacific/Kiritimati"
                                            {{ config('app.timezone') == 'Pacific/Kiritimati' ? 'selected' : '' }}>
                                            (GMT+14:00)
                                            Kiritimati</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_currency">Default Currency</label>
                                    <select name="APP_CURRENCY" id="app_currency" class="form-control">
                                        <option value="USD" {{ config('app.currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ config('app.currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                        <option value="INR" {{ config('app.currency') == 'INR' ? 'selected' : '' }}>INR</option>
                                        <option value="GBP" {{ config('app.currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                                        <option value="RUB" {{ config('app.currency') == 'RUB' ? 'selected' : '' }}>RUB</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_minimum_payout">Minimum Payout</label>
                                    <input type="number" name="APP_MINIMUM_PAYOUT" id="app_minimum_payout"
                                        class="form-control" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" step="0.01"
                                        value="{{ config('app.minimum_payout') }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="app_referral_commission">Referral Commission (%)</label>
                                    <input type="number" name="APP_REFERRAL_COMMISSION" id="app_referral_commission"
                                        class="form-control" pattern="^[0-9]{1,2}(\.[0-9]{0,6})?$" step="0.01"
                                        value="{{ config('app.referral_commission') }}">
                                </div>
                                <div class="form-group mb-4">
                                    <label for="app_offer_fallback">Global Fallback URL</label>
                                    <input type="text" name="APP_OFFER_FALLBACK" id="app_offer_fallback" class="form-control"
                                        value="{{ config('app.offer_fallback') }}" placeholder="Ex. https://google.com">
                                    <small class="form-text text-muted">If country/device/browser mismatch, traffic will be redirected to the global fallback URL.</small>
                                </div>
                                <div class="text-center mb-3">
                                    <button class="btn btn-primary" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
