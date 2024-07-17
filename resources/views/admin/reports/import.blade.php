<x-admin>
   @section('title')  {{ 'Import Data' }} @endsection
    <section class="content">
        <!-- Default box -->
        <div class="d-flex justify-content-center">
            <div class="col-lg-8">
                <div class="card card-primary">
                <h5 class="card-header  white-text text-left py-3">
                    {{ $title }}
                </h5>
                    <!-- /.card-header -->
                            <!-- form start -->
                    <form action="{{ route('admin.report.import') }}" method="POST"
                         class="text-center border border-light p-5" id="importData"  enctype="multipart/form-data">
                         @csrf
                        <div class="card-body px-lg-2 pt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group text-left">
                                                    <label for="type" class="form-label">Select Type</label>
                                                    <span class="required"> * </span>
                                                    <select id="type" name="type" class="selectpicker show-tick col-lg-12" required>
                                                        <option value="customer">Customer</option>
                                                        <option value="item">Items</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group text-left">
                                                    <label for="file" class="form-label">Select File</label>
                                                    <span class="required"> * </span>
                                                    <input type="file" class="form-control" name="file" id="file"
                                                        value="" autocomplete="off"  required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="submit">Import</button>
                                </div>
                                </div><br>
                        </div>
                        </div>
                        </form>
                </div> 

            </div>
        </div>
        <!-- /.card --> 
    </section>
    
    @section('js')
        <script>
            $(document).ready(function() {

             
            });

        </script>
 
    @endsection
</x-admin>
