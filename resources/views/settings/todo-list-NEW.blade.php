<x-layout>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        /* Your existing project styles */
        .portlet.light.portlet-list-view { background: #fff; border: 1px solid #e7ecf1; }
        .portlet-title { padding: 15px 20px; border-bottom: 1px solid #eef1f5; }
        .caption-subject { font-size: 16px; font-weight: 600; color: #32c5d2; }
        
        .portlet-tool { padding: 10px 20px; background: #fafafa; border-bottom: 1px solid #eef1f5; }
        .pull-left._mg-bottom-10 { display: flex; gap: 8px; }
        .btn-group { display: inline-flex; }
        .btn-group .btn { margin: 0; border-radius: 0; }
        .btn-group .btn:first-child { border-radius: 4px 0 0 4px; }
        .btn-group .btn:last-child { border-radius: 0 4px 4px 0; }
        
        .btn.btn-default { background: #fff; border: 1px solid #e7ecf1; color: #666; padding: 6px 12px; }
        .btn.btn-default.active { background: #32c5d2; color: #fff; border-color: #32c5d2; }
        .btn.green { background: #32c5d2; color: #fff; border: none; }
        .btn.blue-hoki { background: #67809f; color: #fff; }
        
        .to-do-setting-list { padding: 15px; max-height: calc(100vh - 300px); overflow-y: auto; }
        .to-do-setting { background: #fff; border: 1px solid #e7ecf1; border-radius: 4px; padding: 12px; margin-bottom: 10px; cursor: pointer; transition: all 0.2s; }
        .to-do-setting:hover { border-color: #32c5d2; box-shadow: 0 2px 4px rgba(50, 197, 210, 0.1); }
        .to-do-setting.active { background: #f0f9ff; border-color: #32c5d2; }
        
        ._flex { display: flex; align-items: center; justify-content: space-between; }
        ._flex-1 { flex: 1; min-width: 0; }
        ._font-14 { font-size: 14px; }
        ._font-15 { font-size: 15px; }
        ._font-12 { font-size: 12px; }
        .bold { font-weight: 600; }
        .text-hidden { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .text-muted { color: #999; }
        ._mg-right-10 { margin-right: 10px; }
        .mg-left-xs { margin-left: 5px; }
        
        .to-do-setting-block { padding: 20px; }
        .block-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; color: #333; }
        
        .setting-card-group { }
        .start-card { background: #fff; border: 1px solid #e7ecf1; border-radius: 4px; padding: 15px; margin-bottom: 15px; }
        
        .setting-row { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .setting-row:last-child { margin-bottom: 0; }
        .start-wording { min-width: 30px; font-size: 13px; color: #666; font-weight: 600; }
        .setting-select { flex: 1; display: flex; gap: 8px; }
        .select.value-sm { padding: 5px 8px; font-size: 12px; border: 1px solid #e7ecf1; border-radius: 3px; flex: 1; }
        .w-34per { width: 34%; font-size: 12px; }
        .w-29per { width: 29%; font-size: 12px; }
        
        .delete-btn { min-width: 24px; }
        .delete-btn a { color: #999; font-size: 14px; }
        .delete-btn a:hover { color: #e74c3c; }
        
        .connect-area { text-align: center; padding: 15px 0; position: relative; }
        .connect-line { flex: 1; height: 1px; background: #ddd; display: inline-block; width: 40%; }
        
        .condition-card { background: #f9f9f9; border: 1px solid #e7ecf1; border-radius: 4px; padding: 15px; margin-bottom: 15px; }
        .text-primary { color: #32c5d2; }
        
        .action-card { background: #f0f9ff; border: 1px solid #e7ecf1; border-radius: 4px; padding: 15px; }
        .text-success { color: #36d7b7; }
        
        .form-control.value-sm { padding: 6px 10px; font-size: 12px; border: 1px solid #e7ecf1; border-radius: 3px; }
        
        .btn.btn-sm { padding: 5px 12px; font-size: 12px; }
        .btn.btn-primary { background: #32c5d2; color: #fff; border: none; }
        .btn.btn-sm.green { background: #36d7b7; color: #fff; border: none; }
        
        .clearfix::after { content: ""; display: table; clear: both; }
        .pull-right { float: right; }
    </style>

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
                        <button class="btn btn-default active" onclick="switchModule('ocean-import')">Ocean Import</button>
                        <button class="btn btn-default" onclick="switchModule('ocean-export')">Ocean Export</button>
                        <button class="btn btn-default" onclick="switchModule('air-import')">Air Import</button>
                        <button class="btn btn-default" onclick="switchModule('air-export')">Air Export</button>
                    </div>
                    <div class="btn-group">
                        <button class="btn green" onclick="addTask()"><i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div class="actions pull-right">
                    <div class="btn-group">
                        <a class="btn blue-hoki btn-circle btn-sm"><i class="fa fa-cogs"></i> Config</a>
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
    let tasks = @json($tasks ?? []);
    let currentModule = 'ocean-import';
    let selectedTaskId = null;

    function renderTaskList() {
        const filteredTasks = tasks.filter(t => t.module === currentModule);
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
                <div class="text-muted text-hidden">${task.description || ''}</div>
            </div>
        `).join('');
        
        document.getElementById('task-list').innerHTML = html || '<div style="text-align:center;padding:40px;color:#999;">No tasks yet</div>';
    }

    function selectTask(taskId) {
        selectedTaskId = taskId;
        const task = tasks.find(t => t.id === taskId);
        if (!task) return;
        
        renderTaskList();
        renderConfigPanel(task);
    }

    function renderConfigPanel(task) {
        // This would render your exact config structure from the HTML
        document.getElementById('config-panel').innerHTML = `
            <div class="block-title">${task.title} <a href="javascript:;" class="mg-left-xs"><i class="fa fa-pencil text-muted"></i></a></div>
            <div class="setting-card-group">
                <!-- When to Start Card -->
                <div class="start-card">
                    <div class="_font-15 bold"><i class="fa fa-clock-o"></i> When to Start</div>
                    <div class="setting-row">
                        <div class="start-wording"></div>
                        <div class="setting-select">
                            <select class="select value-sm">
                                <option>0 Days</option>
                                <option>1 Days</option>
                                <option>2 Days</option>
                                <!-- Add more options -->
                            </select>
                            <select class="select value-sm">
                                <option>Before</option>
                                <option>After</option>
                            </select>
                            <select class="select value-sm">
                                <option>MBL: ETD</option>
                                <option>MBL: ETA</option>
                                <option>MBL: Post Date</option>
                                <!-- Add more date options -->
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Condition Card -->
                <div class="connect-area">
                    <span class="connect-line"></span>
                    <div class="_font-12 text-muted">And</div>
                    <span class="connect-line"></span>
                </div>
                
                <div class="condition-card">
                    <div class="_flex">
                        <div class="_font-15 bold text-primary _flex-1"><i class="fa fa-filter"></i> Condition</div>
                        <a href="javascript:;"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="setting-row">
                        <div class="start-wording">If</div>
                        <div class="setting-select">
                            <select class="select value-sm">
                                <option>HBL: (Express) OB/L received</option>
                                <option>MBL: Oversea Agent</option>
                                <option>MBL: Carrier</option>
                                <option>MBL: Vessel</option>
                                <!-- Add all your freight fields -->
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
                    <a href="javascript:;" class="text-muted"><i class="fa fa-plus"></i> "Or" Condition</a>
                </div>
                
                <!-- Action Card -->
                <div class="connect-area">
                    <span class="connect-line"></span>
                    <div><button type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> "And" Condition</button></div>
                    <span class="connect-line"></span>
                </div>
                
                <div class="action-card">
                    <div class="_flex">
                        <div class="_font-15 bold text-success _flex-1"><i class="fa fa-bolt"></i> Action</div>
                    </div>
                    <div class="setting-row">
                        <div>Show MBL Notification</div>
                        <input type="text" class="form-control value-sm _flex-1" placeholder="Customize the Message if you need (Optional)">
                    </div>
                    <div class="setting-row">
                        <div>Show HBL Notification</div>
                        <input type="text" class="form-control value-sm _flex-1" placeholder="Customize the Message if you need (Optional)">
                    </div>
                </div>
                
                <div class="connect-area">
                    <span class="connect-line"></span>
                    <div><button type="button" class="btn btn-sm green"><i class="fa fa-plus"></i> Action</button></div>
                </div>
            </div>
        `;
    }

    function switchModule(module) {
        currentModule = module;
        selectedTaskId = null;
        
        // Update active button
        document.querySelectorAll('.portlet-tool .btn-default').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        
        renderTaskList();
        document.getElementById('config-panel').innerHTML = '<div style="text-align:center;padding:60px;color:#999;"><i class="fa fa-hand-pointer-o" style="font-size:48px;display:block;margin-bottom:15px;opacity:0.3;"></i><p>Select a task to configure</p></div>';
    }

    function addTask() {
        // Add new task logic
        alert('Add new task - to be implemented');
    }

    function duplicateTask(taskId) {
        // Duplicate task logic
        alert('Duplicate task ' + taskId);
    }

    function deleteTask(taskId) {
        if (confirm('Delete this task?')) {
            // Delete logic
            alert('Delete task ' + taskId);
        }
    }

    // Initialize
    renderTaskList();
    if (tasks.length > 0) {
        selectTask(tasks[0].id);
    }
    </script>
</x-layout>
