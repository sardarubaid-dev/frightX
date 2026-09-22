<!-- Track & Trace Enterprise Component -->
<div x-data="trackTraceComponent()" x-cloak>
    <!-- Dynamic Track & Trace Modal -->
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15, 23, 42, 0.65); backdrop-filter:blur(3px); z-index:99999; display:flex; justify-content:center; align-items:center;" 
         @click.self="closeModal()">
        
        <div style="background:#ffffff; width:620px; max-width:92vw; border-radius:8px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.35); overflow:hidden; font-family:'Inter', sans-serif;">
            
            <!-- Header -->
            <div style="padding:16px 20px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; background:#f8fafc;">
                <h3 style="font-size:15px; font-weight:700; color:#1e293b; margin:0; display:flex; align-items:center; gap:8px;">
                    <i class="fa fa-external-link" style="font-size:16px; color:#3b82f6;"></i> Track & Trace Center
                </h3>
                <button type="button" @click="closeModal()" style="background:none; border:none; font-size:20px; color:#94a3b8; cursor:pointer; line-height:1; transition:color 0.2s;" onmouseover="this.style.color='#1e293b'" onmouseout="this.style.color='#94a3b8'">&times;</button>
            </div>
            
            <!-- Body -->
            <div style="padding:20px; font-size:12px; color:#334155;">
                <!-- Tracking Service Category Selector -->
                <label style="font-size:11px; font-weight:600; color:#475569; text-transform:uppercase; letter-spacing:0.05em; display:block; margin-bottom:8px;">Select Tracking Category</label>
                <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:8px; margin-bottom:18px;">
                    <button type="button" 
                            @click="trackType = 'aircargo'"
                            :style="trackType === 'aircargo' ? 'background:#eff6ff; border:2px solid #3b82f6; color:#1d4ed8; font-weight:600;' : 'background:#f8fafc; border:1px solid #cbd5e1; color:#64748b;'"
                            style="padding:10px; border-radius:6px; font-size:12px; cursor:pointer; display:flex; flex-direction:column; align-items:center; gap:6px; transition:all 0.15s;">
                        <i class="fa fa-plane" style="font-size:18px;"></i>
                        <span>Air Cargo (AWB)</span>
                    </button>

                    <button type="button" 
                            @click="trackType = 'container'"
                            :style="trackType === 'container' ? 'background:#eff6ff; border:2px solid #3b82f6; color:#1d4ed8; font-weight:600;' : 'background:#f8fafc; border:1px solid #cbd5e1; color:#64748b;'"
                            style="padding:10px; border-radius:6px; font-size:12px; cursor:pointer; display:flex; flex-direction:column; align-items:center; gap:6px; transition:all 0.15s;">
                        <i class="fa fa-cube" style="font-size:18px;"></i>
                        <span>Container No.</span>
                    </button>

                    <button type="button" 
                            @click="trackType = 'bol'"
                            :style="trackType === 'bol' ? 'background:#eff6ff; border:2px solid #3b82f6; color:#1d4ed8; font-weight:600;' : 'background:#f8fafc; border:1px solid #cbd5e1; color:#64748b;'"
                            style="padding:10px; border-radius:6px; font-size:12px; cursor:pointer; display:flex; flex-direction:column; align-items:center; gap:6px; transition:all 0.15s;">
                        <i class="fa fa-ship" style="font-size:18px;"></i>
                        <span>Bill of Lading (B/L)</span>
                    </button>
                </div>

                <!-- Suggested Numbers from Current Context -->
                <template x-if="suggestedNumbers.length > 0">
                    <div style="margin-bottom:16px; padding:10px; background:#f1f5f9; border-radius:6px; border:1px dashed #cbd5e1;">
                        <span style="font-size:10px; font-weight:700; color:#64748b; text-transform:uppercase; display:block; margin-bottom:6px;">Available Numbers in Active Shipment:</span>
                        <div style="display:flex; flex-wrap:wrap; gap:6px;">
                            <template x-for="item in suggestedNumbers" :key="item.number">
                                <button type="button" 
                                        @click="trackingNumber = item.number; trackType = item.type || trackType"
                                        style="background:#ffffff; border:1px solid #94a3b8; border-radius:4px; padding:4px 10px; font-size:11px; color:#1e293b; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:5px; transition:all 0.15s;"
                                        onmouseover="this.style.borderColor='#3b82f6'; this.style.color='#3b82f6'"
                                        onmouseout="this.style.borderColor='#94a3b8'; this.style.color='#1e293b'">
                                    <span x-text="item.label + ': ' + item.number"></span>
                                    <i class="fa fa-arrow-circle-right" style="font-size:11px; color:#3b82f6;"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Input Tracking Number -->
                <div style="margin-bottom:15px;">
                    <label style="font-size:11px; font-weight:600; color:#475569; display:block; margin-bottom:4px;">Tracking Number / AWB / Container No.</label>
                    <div style="display:flex; gap:8px;">
                        <input type="text" 
                               x-model="trackingNumber" 
                               @keyup.enter="submitTracking()"
                               placeholder="e.g. 999-05191105 or MSKU1234567"
                               style="flex:1; height:36px; padding:0 12px; border:1px solid #cbd5e1; border-radius:4px; font-size:12px; font-weight:500; font-family:monospace; background:#fff; outline:none; transition:border 0.2s;"
                               onfocus="this.style.borderColor='#3b82f6'"
                               onblur="this.style.borderColor='#cbd5e1'">
                    </div>
                    <span style="font-size:10px; color:#64748b; margin-top:4px; display:block;">
                        Enter the Air Waybill number, Container number, or Ocean Bill of Lading number to trace live tracking results.
                    </span>
                </div>
            </div>

            <!-- Footer -->
            <div style="padding:12px 20px; border-top:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; background:#f8fafc;">
                <span style="font-size:11px; color:#94a3b8;">Powered by Track-Trace Enterprise Integration</span>
                <div style="display:flex; gap:8px;">
                    <button type="button" @click="closeModal()" style="padding:6px 14px; font-size:12px; background:#fff; border:1px solid #cbd5e1; color:#475569; border-radius:4px; cursor:pointer; font-weight:500;">Cancel</button>
                    <button type="button" @click="submitTracking()" style="padding:6px 18px; font-size:12px; background:#3b82f6; border:none; color:#fff; border-radius:4px; cursor:pointer; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fa fa-external-link"></i> Track Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        // Global helper for opening track-trace
        window.openTrackTrace = function(opts = {}) {
            let number = '';
            let type = '';

            if (typeof opts === 'string') {
                number = opts.trim();
            } else if (opts && typeof opts === 'object') {
                number = opts.number ? String(opts.number).trim() : '';
                type = opts.type || '';
            }

            // If number provided, auto-detect type if needed and launch immediately
            if (number) {
                if (!type) {
                    if (/^\d{3}[-\s]?\d{8}$/.test(number) || /^\d{11}$/.test(number)) {
                        type = 'aircargo';
                    } else if (/^[A-Z]{4}\d{7}$/i.test(number)) {
                        type = 'container';
                    } else {
                        type = 'bol';
                    }
                }
                window.executeTrackTraceSubmit(number, type || 'aircargo');
            } else {
                // Open modal with context inspection
                if (window.trackTraceModalInstance) {
                    window.trackTraceModalInstance.open(type || 'aircargo');
                } else {
                    console.warn('Track-Trace modal instance not found.');
                }
            }
        };

        window.executeTrackTraceSubmit = function(number, type) {
            type = type || 'aircargo';
            if (typeof showToast === 'function') {
                showToast('info', 'Opening Track-Trace for ' + number + '...');
            }

            // Create form to POST to track-trace with commit parameter
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'https://www.track-trace.com/' + type;
            form.target = '_blank';

            const numInput = document.createElement('input');
            numInput.type = 'hidden';
            numInput.name = 'number';
            numInput.value = number;
            form.appendChild(numInput);

            const commitInput = document.createElement('input');
            commitInput.type = 'hidden';
            commitInput.name = 'commit';
            commitInput.value = 'Track with options';
            form.appendChild(commitInput);

            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        };
    });

    function trackTraceComponent() {
        return {
            showModal: false,
            trackType: 'aircargo',
            trackingNumber: '',
            suggestedNumbers: [],

            init() {
                window.trackTraceModalInstance = this;
            },

            open(preferredType = 'aircargo') {
                this.trackType = preferredType || 'aircargo';
                this.trackingNumber = '';
                this.inspectActiveContext();
                this.showModal = true;
            },

            closeModal() {
                this.showModal = false;
            },

            inspectActiveContext() {
                this.suggestedNumbers = [];
                const suggestions = [];

                // Try finding Alpine components on screen or inputs
                const inputs = document.querySelectorAll('input[name="mawb_no"], input[name="mbl_no"], input[name="hbl_no"], input[name="hawb_no"], input[name="container_no"], input[x-model*="mawb"], input[x-model*="mbl"], input[x-model*="hbl"], input[x-model*="container"]');
                
                inputs.forEach(input => {
                    const val = input.value ? input.value.trim() : '';
                    if (val && val.length >= 4) {
                        let label = 'Number';
                        let type = 'aircargo';
                        const name = (input.getAttribute('name') || input.getAttribute('x-model') || '').toLowerCase();

                        if (name.includes('mawb') || name.includes('hawb')) {
                            label = name.includes('mawb') ? 'MAWB' : 'HAWB';
                            type = 'aircargo';
                        } else if (name.includes('mbl') || name.includes('hbl')) {
                            label = name.includes('mbl') ? 'MBL' : 'bol';
                        } else if (name.includes('container')) {
                            label = 'Container';
                            type = 'container';
                        }

                        if (!suggestions.some(s => s.number === val)) {
                            suggestions.push({ label, number: val, type });
                        }
                    }
                });

                // Check active Alpine scope
                try {
                    const rootEl = document.querySelector('[x-data]');
                    if (rootEl && window.Alpine) {
                        const data = Alpine.$data(rootEl);
                        if (data && data.form) {
                            if (data.form.mawb_no) suggestions.push({ label: 'MAWB', number: data.form.mawb_no, type: 'aircargo' });
                            if (data.form.mbl_no) suggestions.push({ label: 'MBL', number: data.form.mbl_no, type: 'bol' });
                            if (data.form.hbl_no) suggestions.push({ label: 'HBL', number: data.form.hbl_no, type: 'bol' });
                            if (data.form.hawb_no) suggestions.push({ label: 'HAWB', number: data.form.hawb_no, type: 'aircargo' });
                        }
                    }
                } catch (e) {}

                // Deduplicate suggestions
                const unique = [];
                const seen = new Set();
                suggestions.forEach(item => {
                    if (item.number && !seen.has(item.number)) {
                        seen.add(item.number);
                        unique.push(item);
                    }
                });

                this.suggestedNumbers = unique;
                if (this.suggestedNumbers.length > 0) {
                    this.trackingNumber = this.suggestedNumbers[0].number;
                    if (this.suggestedNumbers[0].type) {
                        this.trackType = this.suggestedNumbers[0].type;
                    }
                }
            },

            submitTracking() {
                if (!this.trackingNumber || !this.trackingNumber.trim()) {
                    if (typeof showToast === 'function') {
                        showToast('warning', 'Please enter a tracking number.');
                    } else {
                        alert('Please enter a tracking number.');
                    }
                    return;
                }

                const num = this.trackingNumber.trim();
                const type = this.trackType || 'aircargo';

                this.closeModal();
                window.executeTrackTraceSubmit(num, type);
            }
        };
    }
</script>
