<div id="new-pipeline-template" class="modal fade custom-fields show" style="display: block;">
    <div role="document" class="modal-dialog modal-lg modal-dialog-centered">
        <form action="">
            <div class="modal-content">
                <div class="modal-header"><h4 class="modal-title text-uppercase">edit job pipeline</h4>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="d-flex justify-content-between"><label>Select A Template</label> <label
                                    class="checkbox"><input type="checkbox"> <span>Remote Interview</span></label></div>
                        <div class="select-option"><select>
                                <option value="">Select A Template</option>
                                <option value="0">New Job</option>
                                <option value="1">Test001</option>
                                <option value="2">Test001</option>
                            </select></div>
                        <div class="error-message"></div>
                    </div>
                    <div class="form-group pipeline-step-list"><label>Pipeline Steps</label>
                        <div>
                            <div class="input-wrapper pipeline-wrapper"><input type="text" name="" disabled="disabled"
                                                                               class="form-control"> <!----></div>
                            <div class="input-wrapper pipeline-wrapper" draggable="false">
                                <input type="text" name="" disabled="disabled"class="form-control">
                                <a href="#" class="input-wrapper-append" draggable="false"><i
                                            class="eicon e-delete"></i></a>
                            </div>
                            <div class="input-wrapper pipeline-wrapper" draggable="false"><input type="text" name="" disabled="disabled" class="form-control">
                                <a href="#" class="input-wrapper-append" draggable="false"><i
                                            class="eicon e-delete"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12"><label>New Pipeline Step Name</label></div>
                        <div class="col-md-9">
                            <input type="text" name="" placeholder="New step title" class="form-control">
                            <div class="error-message"></div>
                        </div>
                        <div class="col-md-3">
                            <button class="button semi-button-info w-100">Add New</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button data-dismiss="modal" class="button semi-button-info">Back</button>
                    <button type="submit" class="button info-button">Save &amp; Continue</button>
                </div>
            </div>
        </form>
    </div>
</div>