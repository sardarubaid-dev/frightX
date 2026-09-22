<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @push('styles')
    <style>
        /* EXACT PROJECT PORTLET STYLING */
        .portlet.light.portlet-list-view {
            background: #fff;
            border: 1px solid #e7ecf1;
            margin-bottom: 10px;
        }
        
        .portlet-title {
            padding: 15px 20px;
            border-bottom: 1px solid #eef1f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .caption-subject.font-blue-steel {
            font-size: 16px;
            font-weight: 600;
            color: #32c5d2;
        }
        
        /* PORTLET TOOL - EXACT PROJECT STYLING */
        .portlet-tool {
            padding: 10px 20px;
            background: #fafafa;
            border-bottom: 1px solid #eef1f5;
        }
        
        .pull-left._mg-bottom-10 {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        
        /* BUTTON GROUP - EXACT PROJECT STYLING */
        .btn-group {
            display: inline-flex;
            box-shadow: none;
        }
        
        .btn-group .btn {
            margin: 0;
            border-radius: 0;
            border-right: 1px solid #ddd;
        }
        
        .btn-group .btn:first-child {
            border-radius: 4px 0 0 4px;
        }
        
        .btn-group .btn:last-child {
            border-radius: 0 4px 4px 0;
            border-right: none;
        }
        
        .btn.btn-default {
            background: #fff;
            border: 1px solid #e7ecf1;
            color: #666;
            padding: 6px 12px;
            font-size: 12px;
            height: 32px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .btn.btn-default:hover {
            background: #f5f5f5;
        }
        
        .btn.btn-default.active {
            background: #32c5d2;
            color: #fff;
            border-color: #32c5d2;
        }
        
        .btn.green {
            background: #32c5d2;
            color: #fff;
            border: none;
            padding: 6px 12px;
            font-size: 14px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn.green:hover {
            background: #27a9b5;
        }
        
        .btn.blue-hoki {
            background: #67809f;
            color: #fff;
            border: none;
            padding: 6px 12px;
            font-size: 12px;
            height: 32px;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .btn.blue-hoki:hover {
            background: #597089;
        }
        
        .actions.pull-right {
            float: right;
        }
        
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
        
        /* TWO-COLUMN LAYOUT - EXACT PROJECT STYLING */
        .row {
            display: flex;
            margin: 0;
        }
        
        .col-xs-7 {
            width: 58.33333333%;
            padding: 0 15px;
        }
        
        .col-xs-5 {
            width: 41.66666667%;
            padding: 0 15px;
        }
        
        /* TASK LIST - EXACT PROJECT STYLING */
        .to-do-setting-list {
            padding: 15px;
            max-height: calc(100vh - 300px);
            overflow-y: auto;
        }
        
        .to-do-setting {
            background: #fff;
            border: 1px solid #e7ecf1;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .to-do-setting:hover {
            border-color: #32c5d2;
            box-shadow: 0 2px 4px rgba(50, 197, 210, 0.1);
        }
        
        .to-do-setting.active {
            background: #f0f9ff;
            border-color: #32c5d2;
        }
        
        ._flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        ._flex-1 {
            flex: 1;
            min-width: 0;
        }
        
        ._font-14 {
            font-size: 14px;
        }
        
        ._font-15 {
            font-size: 15px;
        }
        
        ._font-12 {
            font-size: 12px;
        }
        
        .bold {
            font-weight: 600;
        }
        
        .text-hidden {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .text-muted {
            color: #999;
        }
        
        ._mg-right-10 {
            margin-right: 10px;
        }
        
        .mg-left-xs {
            margin-left: 5px;
        }
        
        /* CONFIG BLOCK - EXACT PROJECT STYLING */
        .to-do-setting-block {
            padding: 20px;
        }
        
        .block-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }
        
        /* SETTING CARDS - EXACT PROJECT STYLING */
        .setting-card-group {
            /* Container for all setting cards */
        }
        
        .start-card,
        .condition-card,
        .action-card {
            background: #fff;
            border: 1px solid #e7ecf1;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 15px;
        }
        
        .condition-card {
            background: #f9f9f9;
        }
        
        .action-card {
            background: #f0f9ff;
        }
        
        /* SETTING ROW - EXACT PROJECT STYLING */
        .setting-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        
        .setting-row:last-child {
            margin-bottom: 0;
        }
        
        .start-wording {
            min-width: 30px;
            font-size: 13px;
            color: #666;
            font-weight: 600;
        }
        
        .setting-select {
            flex: 1;
            display: flex;
            gap: 8px;
        }
        
        .select.value-sm {
            padding: 5px 8px;
            font-size: 12px;
            border: 1px solid #e7ecf1;
            border-radius: 3px;
            flex: 1;
            background: #fff;
            color: #333;
            cursor: pointer;
        }
        
        .w-34per {
            width: 34%;
            font-size: 12px;
        }
        
        .w-29per {
            width: 29%;
            font-size: 12px;
        }
        
        .delete-btn {
            min-width: 24px;
        }
        
        .delete-btn a {
            color: #999;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }
        
        .delete-btn a:hover {
            color: #e74c3c;
        }
        
        /* CONNECT AREA - EXACT PROJECT STYLING */
        .connect-area {
            text-align: center;
            padding: 15px 0;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        
        .connect-line {
            flex: 1;
            height: 1px;
            background: #ddd;
            max-width: 40%;
        }
        
        /* TEXT COLORS - EXACT PROJECT STYLING */
        .text-primary {
            color: #32c5d2;
        }
        
        .text-success {
            color: #36d7b7;
        }
        
        /* FORM CONTROL - EXACT PROJECT STYLING */
        .form-control.value-sm {
            padding: 6px 10px;
            font-size: 12px;
            border: 1px solid #e7ecf1;
            border-radius: 3px;
            width: 100%;
            background: #fff;
        }
        
        /* BUTTON SMALL - EXACT PROJECT STYLING */
        .btn.btn-sm {
            padding: 5px 12px;
            font-size: 12px;
            height: auto;
            border-radius: 3px;
        }
        
        .btn.btn-primary {
            background: #32c5d2;
            color: #fff;
            border: none;
        }
        
        .btn.btn-primary:hover {
            background: #27a9b5;
        }
        
        .btn.btn-sm.green {
            background: #36d7b7;
            color: #fff;
            border: none;
        }
        
        .btn.btn-sm.green:hover {
            background: #2fbea2;
        }
        
        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 70px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .toast {
            background: #1e293b;
            color: #fff;
            padding: 12px 18px;
            border-radius: 4px;
            font-size: 13px;
            min-width: 250px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideIn 0.3s ease;
        }
        
        .toast.success {
            border-left: 4px solid #22c55e;
        }
        
        .toast.error {
            border-left: 4px solid #ef4444;
        }
        
        .toast.info {
            border-left: 4px solid #3b82f6;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        /* Page Bar Breadcrumbs */
        .page-bar {
            background-color: #fff;
            padding: 10px 20px;
            margin-bottom: 20px;
            border: 1px solid #e9ebec;
            border-radius: 4px;
        }
        
        .page-breadcrumb {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }
        
        .page-breadcrumb li {
            font-size: 13px;
            color: #888;
            display: flex;
            align-items: center;
        }
        
        .page-breadcrumb li a {
            color: #337ab7;
            text-decoration: none;
        }
        
        .page-breadcrumb li a:hover {
            color: #1d4ed8;
        }
        
        .page-breadcrumb li i {
            margin: 0 10px;
            font-size: 11px;
            opacity: 0.5;
        }
    </style>
    @endpush

    {{-- Toast Container --}}
    <div class="toast-container" id="toast-container"></div>

    <!-- Breadcrumb -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li><i class="fa fa-home"></i> <a href="/">Home</a> <i class="fa fa-angle-right"></i></li>
            <li><a href="/settings">Settings</a> <i class="fa fa-angle-right"></i></li>
            <li><span style="color: #333; font-weight: 700;">To Do List Setting</span></li>
        </ul>
    </div>

    <div class="portlet light portlet-list-view">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-blue-steel bold">To Do List Setting</span>
            </div>
        </div>
        
        <div class="portlet-body">
            <div class="portlet-tool">
                <div class="pull-left _mg-bottom-10">
                    <div class="btn-group">
                        <button class="btn btn-default active" data-module="ocean-import" onclick="switchModule(this, 'ocean-import')">Ocean Import</button>
                        <button class="btn btn-default" data-module="ocean-export" onclick="switchModule(this, 'ocean-export')">Ocean Export</button>
                        <button class="btn btn-default" data-module="air-import" onclick="switchModule(this, 'air-import')">Air Import</button>
                        <button class="btn btn-default" data-module="air-export" onclick="switchModule(this, 'air-export')">Air Export</button>
                        <button class="btn btn-default" data-module="trucking" onclick="switchModule(this, 'trucking')">Trucking</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn green" onclick="addTask()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="actions pull-right">
                    <div class="btn-group">
                        <a class="btn blue-hoki btn-circle btn-sm" href="javascript:;"><i class="fa fa-cogs"></i> Config</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            
            <div class="row">
                <div class="col-xs-7">
                    <div class="to-do-setting-list" id="task-list">
                        <!-- Task items will be loaded here -->
                    </div>
                </div>
                
                <div class="col-xs-5">
                    <div class="to-do-setting-block" id="config-panel">
                        <!-- Config will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // State
    let tasks = [];
    let currentModule = 'ocean-import';
    let selectedTaskId = null;

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        loadTasks();
    });

    // Load tasks from API
    function loadTasks() {
        fetch('/api/todo-tasks?module=' + currentModule)
            .then(response => response.json())
            .then(data => {
                tasks = data;
                renderTaskList();
                if (tasks.length > 0 && !selectedTaskId) {
                    selectTask(tasks[0].id);
                }
            })
            .catch(error => {
                console.error('Error loading tasks:', error);
                showToast('error', 'Failed to load tasks');
            });
    }

    // Render task list
    function renderTaskList() {
        const filteredTasks = tasks.filter(t => t.module === currentModule);
        
        if (filteredTasks.length === 0) {
            document.getElementById('task-list').innerHTML = `
                <div style="text-align:center;padding:60px 20px;color:#999;">
                    <i class="fa fa-inbox" style="font-size:48px;display:block;margin-bottom:15px;opacity:0.3;"></i>
                    <p style="font-size:14px;margin:0;">No tasks yet</p>
                    <p style="font-size:12px;margin:5px 0 0 0;">Click the + button to create your first task</p>
                </div>
            `;
            document.getElementById('config-panel').innerHTML = '';
            return;
        }
        
        const html = filteredTasks.map(task => `
            <div class="to-do-setting ${selectedTaskId === task.id ? 'active' : ''}" onclick="selectTask(${task.id})">
                <div class="_flex">
                    <div class="_flex-1 text-hidden _font-14 bold">${task.title || 'Untitled'}</div>
                    <div>
                        <a href="javascript:;" class="_mg-right-10" onclick="event.stopPropagation(); duplicateTask(${task.id})">
                            <i class="fa fa-files-o"></i>
                        </a>
                        <a href="javascript:;" onclick="event.stopPropagation(); deleteTask(${task.id})">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="text-muted text-hidden _font-12">${task.description || ''}</div>
            </div>
        `).join('');
        
        document.getElementById('task-list').innerHTML = html;
    }

    // Switch module
    function switchModule(button, module) {
        currentModule = module;
        selectedTaskId = null;
        
        // Update active button
        document.querySelectorAll('.portlet-tool .btn-default').forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
        
        loadTasks();
        document.getElementById('config-panel').innerHTML = `
            <div style="text-align:center;padding:60px 20px;color:#999;">
                <i class="fa fa-hand-pointer-o" style="font-size:48px;display:block;margin-bottom:15px;opacity:0.3;"></i>
                <p style="font-size:14px;margin:0;">Select a task to configure</p>
            </div>
        `;
    }

    // Select task
    function selectTask(taskId) {
        selectedTaskId = taskId;
        const task = tasks.find(t => t.id === taskId);
        if (!task) return;
        
        renderTaskList();
        renderConfigPanel(task);
    }

    // Render config panel
    function renderConfigPanel(task) {
        const config = task.config || {};
        
        document.getElementById('config-panel').innerHTML = `
            <div class="block-title">
                ${task.title || 'Untitled'} 
                <a href="javascript:;" class="mg-left-xs"><i class="fa fa-pencil text-muted"></i></a>
            </div>
            
            <div class="setting-card-group">
                <!-- When to Start Card -->
                <div class="start-card">
                    <div class="_font-15 bold"><i class="fa fa-clock-o"></i> When to Start</div>
                    <div class="setting-row" style="margin-top:15px;">
                        <div class="start-wording"></div>
                        <div class="setting-select">
                            <select class="select value-sm" onchange="updateConfig('startDays', this.value)">
                                ${generateDaysOptions(config.startDays)}
                            </select>
                            <select class="select value-sm" onchange="updateConfig('startDirection', this.value)">
                                <option value="before" ${config.startDirection === 'before' ? 'selected' : ''}>Before</option>
                                <option value="after" ${config.startDirection === 'after' ? 'selected' : ''}>After</option>
                            </select>
                            <select class="select value-sm" onchange="updateConfig('startReference', this.value)">
                                <option value="mbl_etd" ${config.startReference === 'mbl_etd' ? 'selected' : ''}>MBL: ETD</option>
                                <option value="mbl_eta" ${config.startReference === 'mbl_eta' ? 'selected' : ''}>MBL: ETA</option>
                                <option value="mbl_post_date" ${config.startReference === 'mbl_post_date' ? 'selected' : ''}>MBL: Post Date</option>
                                <option value="mbl_booking_date" ${config.startReference === 'mbl_booking_date' ? 'selected' : ''}>MBL: Booking Date</option>
                                <option value="shipment_created" ${config.startReference === 'shipment_created' ? 'selected' : ''}>Shipment Created</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- And Connector -->
                <div class="connect-area">
                    <span class="connect-line"></span>
                    <div class="_font-12 text-muted">And</div>
                    <span class="connect-line"></span>
                </div>
                
                <!-- Condition Card -->
                <div class="condition-card">
                    <div class="_flex">
                        <div class="_font-15 bold text-primary _flex-1"><i class="fa fa-filter"></i> Condition</div>
                        <a href="javascript:;"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="setting-row" style="margin-top:15px;">
                        <div class="start-wording">If</div>
                        <div class="setting-select">
                            <select class="select value-sm">
                                <option>HBL: (Express) OB/L received</option>
                                <option>MBL: Oversea Agent</option>
                                <option>MBL: Carrier</option>
                                <option>MBL: Vessel</option>
                                <option>MBL: Voyage</option>
                                <option>HBL: Shipper</option>
                                <option>HBL: Consignee</option>
                                <option>MBL: Port of Loading</option>
                                <option>MBL: Port of Discharge</option>
                                <option>HBL: Customer</option>
                            </select>
                            <select class="select value-sm">
                                <option>is filled</option>
                                <option>is not filled</option>
                                <option>equals to</option>
                            </select>
                        </div>
                        <div class="delete-btn">
                            <a href="javascript:;"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div style="margin-top:10px;">
                        <a href="javascript:;" class="text-muted" style="font-size:12px;"><i class="fa fa-plus"></i> "Or" Condition</a>
                    </div>
                </div>
                
                <!-- Add And Condition -->
                <div class="connect-area">
                    <span class="connect-line"></span>
                    <div><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> "And" Condition</button></div>
                    <span class="connect-line"></span>
                </div>
                
                <!-- Action Card -->
                <div class="action-card">
                    <div class="_flex">
                        <div class="_font-15 bold text-success _flex-1"><i class="fa fa-bolt"></i> Action</div>
                    </div>
                    <div class="setting-row" style="margin-top:15px;">
                        <div style="width:170px;font-size:12px;">Show MBL Notification</div>
                        <input type="text" class="form-control value-sm" placeholder="Customize the Message if you need (Optional)">
                    </div>
                    <div class="setting-row">
                        <div style="width:170px;font-size:12px;">Show HBL Notification</div>
                        <input type="text" class="form-control value-sm" placeholder="Customize the Message if you need (Optional)">
                    </div>
                </div>
                
                <!-- Add Action -->
                <div class="connect-area">
                    <span class="connect-line"></span>
                    <div><button type="button" class="btn btn-sm green"><i class="fa fa-plus"></i> Action</button></div>
                </div>
            </div>
        `;
    }

    // Generate days options
    function generateDaysOptions(selectedDays) {
        let html = '';
        for (let i = 0; i <= 20; i++) {
            const selected = (selectedDays == i) ? 'selected' : '';
            html += `<option value="${i}" ${selected}>${i} Days</option>`;
        }
        return html;
    }

    // Update config
    function updateConfig(key, value) {
        const task = tasks.find(t => t.id === selectedTaskId);
        if (!task) return;
        
        if (!task.config) task.config = {};
        task.config[key] = value;
        
        // Auto-save
        saveTask(task);
    }

    // Save task
    function saveTask(task) {
        const url = task.id ? `/api/todo-tasks/${task.id}` : '/api/todo-tasks';
        const method = task.id ? 'PUT' : 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(task)
        })
        .then(response => response.json())
        .then(data => {
            showToast('success', 'Task saved successfully');
            if (!task.id) {
                task.id = data.id;
                loadTasks();
            }
        })
        .catch(error => {
            console.error('Error saving task:', error);
            showToast('error', 'Failed to save task');
        });
    }

    // Add new task
    function addTask() {
        const newTask = {
            module: currentModule,
            title: 'New Task',
            description: '',
            config: {
                startDays: 0,
                startDirection: 'before',
                startReference: 'mbl_etd'
            }
        };
        
        fetch('/api/todo-tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(newTask)
        })
        .then(response => response.json())
        .then(data => {
            showToast('success', 'New task created');
            loadTasks();
            setTimeout(() => selectTask(data.id), 300);
        })
        .catch(error => {
            console.error('Error creating task:', error);
            showToast('error', 'Failed to create task');
        });
    }

    // Duplicate task
    function duplicateTask(taskId) {
        const task = tasks.find(t => t.id === taskId);
        if (!task) return;
        
        const duplicated = {
            ...task,
            id: null,
            title: task.title + ' (Copy)'
        };
        
        fetch('/api/todo-tasks', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(duplicated)
        })
        .then(response => response.json())
        .then(data => {
            showToast('success', 'Task duplicated');
            loadTasks();
            setTimeout(() => selectTask(data.id), 300);
        })
        .catch(error => {
            console.error('Error duplicating task:', error);
            showToast('error', 'Failed to duplicate task');
        });
    }

    // Delete task
    function deleteTask(taskId) {
        if (!confirm('Are you sure you want to delete this task?')) return;
        
        fetch(`/api/todo-tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            showToast('success', 'Task deleted');
            selectedTaskId = null;
            loadTasks();
        })
        .catch(error => {
            console.error('Error deleting task:', error);
            showToast('error', 'Failed to delete task');
        });
    }

    // Show toast notification
    function showToast(type, message) {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <i class="fa ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-times-circle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
        `;
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }
    </script>
</x-layout>
