<aside class="flex-shrink-0 h-screen" style="background: #405189; width: 220px;">
    <div class="flex flex-col h-screen" style="background: #405189; color: #fff;">
        {{-- Logo Area --}}
        <div style="height: 50px; display: flex; align-items: center; padding: 0 16px; border-bottom: 1px solid rgba(255,255,255,0.1); justify-content: space-between;">
            <a href="{{ route('super-admin.dashboard') }}" style="color: #fff; text-decoration: none; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">
                FMS <span style="color: #0ab39c; font-size: 8px; vertical-align: super;">ADMIN</span>
            </a>
            <button onclick="document.body.classList.remove('sidebar-mobile-open')" class="md:hidden" style="background: none; border: none; color: rgba(255,255,255,0.6); font-size: 14px; cursor: pointer;">
                <i class="fa fa-times"></i>
            </button>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto custom-scrollbar" style="padding: 12px 0;">
            @php
                $menuItems = [
                    ['route' => 'super-admin.dashboard', 'icon' => 'fa-dashboard', 'label' => 'Dashboard', 'match' => 'super-admin'],
                    ['route' => 'super-admin.companies.index', 'icon' => 'fa-building', 'label' => 'Companies', 'match' => 'super-admin/companies'],
                    ['route' => 'super-admin.audit-log', 'icon' => 'fa-history', 'label' => 'Audit Log', 'match' => 'super-admin/audit-log'],
                ];
            @endphp

            <div style="padding: 0 12px 8px; font-size: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(195,203,228,0.7);">
                Management
            </div>

            @foreach($menuItems as $item)
                @php
                    $isActive = $item['match'] === 'super-admin'
                        ? request()->is('super-admin') && !request()->is('super-admin/*')
                        : request()->is($item['match'] . '*');
                @endphp
                <a href="{{ route($item['route']) }}"
                   style="display: flex; align-items: center; padding: 10px 16px; margin: 1px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; text-decoration: none; transition: all 0.2s;
                   {{ $isActive ? 'background: rgba(255,255,255,0.12); color: #fff; border-left: 3px solid #0ab39c;' : 'color: rgba(195,203,228,0.85);' }}"
                   onmouseover="if(!{{ $isActive ? 'true' : 'false' }}) this.style.background='rgba(255,255,255,0.06)'; this.style.color='#fff';"
                   onmouseout="if(!{{ $isActive ? 'true' : 'false' }}) this.style.background='transparent'; this.style.color='rgba(195,203,228,0.85)';">
                    <i class="fa {{ $item['icon'] }}" style="width: 20px; text-align: center; font-size: 12px; margin-right: 10px; opacity: 0.8;"></i>
                    {{ $item['label'] }}
                </a>
            @endforeach

            {{-- Divider --}}
            <div style="margin: 16px 16px 8px; border-top: 1px solid rgba(255,255,255,0.08);"></div>
            <div style="padding: 0 12px 8px; font-size: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(195,203,228,0.7);">
                Quick Links
            </div>

            <a href="/"
               style="display: flex; align-items: center; padding: 10px 16px; margin: 1px 8px; border-radius: 4px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.8px; text-decoration: none; color: rgba(195,203,228,0.85); transition: all 0.2s;"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#fff';"
               onmouseout="this.style.background='transparent'; this.style.color='rgba(195,203,228,0.85)';">
                <i class="fa fa-external-link" style="width: 20px; text-align: center; font-size: 12px; margin-right: 10px; opacity: 0.8;"></i>
                ERP Dashboard
            </a>
        </nav>

        {{-- Footer --}}
        <div style="padding: 12px 16px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 8px; color: rgba(195,203,228,0.5); text-align: center;">
            FMS Super Admin v1.0
        </div>
    </div>
</aside>
