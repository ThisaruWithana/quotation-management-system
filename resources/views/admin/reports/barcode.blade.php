<x-admin>
   @section('title')  {{ 'Reports' }} @endsection
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
                    <form action="{{ route('admin.report.print-label') }}" method="POST" class="text-center border border-light p-5" id="poCreate">
                         @csrf
                        <div class="card-body px-lg-2 pt-0">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group text-left">
                                                    <label for="items" class="form-label">Select Items</label>
                                                    <span class="required"> * </span>
                                                    <select id="items" name="items[]" class="selectpicker show-tick col-lg-12" data-live-search="true" multiple required>
                                                        <option value="">Select Items</option>
                                                        @foreach ($items as $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                
                                <div class="col-lg-2">
                                    <button class="btn btn-primary btn-block" type="submit">Download</button>
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
