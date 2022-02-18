<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">




                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">
                    <div class="card-header">
                        <h3 class="card-title">Daily Activity </h3>
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <!--begin::Form-->

                    <div class="card-body">


                        <div class="form-group row">

                            <div class="col-4 form-group">

                                <label for="example-week-input" class="col-form-label">Tanggal </label>
                                <input type="text" class="form-control" readonly  value="<?php echo date('d-m-Y')?>" id="kt_datepicker_3"/>

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="example-week-input" class="col-4 col-form-label">Start</label>
                                    <input class="form-control" data-default-time="09:00:00" id="kt_timepicker_1_validate" 
                                        placeholder="Select time" type="text" />
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="example-week-input" class="col-4 col-form-label">End</label>
                                    <input class="form-control" data-default-time="17:00:00" id="kt_timepicker_1_validate" 
                                        placeholder="Select time" type="text" />
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Aktifitas <span class="text-danger">*</span></label>
                            
                          
                                <select class="form-control" id="kt_select2_3" required name="ktr_id">
                                <?php 
                                    foreach($wfh_master as $w){
                                        ?>

                                            <option><?php echo $w->wfh_aktifitas?></option>
                                  <?php      
                                    }
                                ?>
                            </select>

                        </div>


                        <div class="form-group row">

                            <div class="col-4 form-group">

                                <label for="example-week-input" class="col-form-label">Aksi </label>
                                <input class="form-control" id=""  placeholder="Select time"
                                    type="text" />

                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="example-week-input" class=" col-form-label">Satuan</label>
                                    <input class="form-control" id=""  placeholder="Select time"
                                        type="text" />
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label for="example-week-input" class="col-form-label">Value</label>
                                    <input class="form-control" id=""  placeholder="Select time"
                                        type="text" />
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi" class="form-control" placeholder="Enter email" />

                        </div>


                        <div class="form-group">
                            <label>Keterangan <span class="text-danger">*</span></label>
                            <textarea name="keterangan" class="form-control" ></textarea>

                        </div>










                    </div>

                </div>
                <!--end::Card-->

            </div>


            <div class="col-md-6">







                <!--begin::Card-->
                <div class="card card-custom gutter-b example example-compact">

                    <!--begin::Form-->

                    <div class="card-header">
                        <h3 class="card-title">Daily Report</h3>
                        <div class="card-toolbar">

                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group mb-8">

                        </div>




                        <div class="form-group row">
                            <label for="example-url-input" class="col-4 col-form-label">Nama Keluarga<span
                                    class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="nama_keluarga"
                                    id="nama_keluarga" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-tel-input" class="col-4 col-form-label">Hubungan Keluarga<span
                                    class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="text" required name="hubungan_keluarga"
                                    id="hubungan_keluarga" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="example-password-input" class="col-4 col-form-label">No Hp Keluarga<span
                                    class="text-danger">*</span> </label>
                            <div class="col-8">
                                <input class="form-control" type="number" value="hunter2" required name="no_hp_keluarga"
                                    id="no_hp_keluarga" />
                            </div>
                        </div>




                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-8">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <!--end::Card-->

            </div>



        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->