<x-admin>
    @section('title')  {{ $title }} @endsection
    <div class="card col-md-8">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
            <div class="card-tools">
                <!-- <a href="{{ route('admin.item.create') }}" class="btn btn-sm btn-primary">Add</a> -->
            </div>
        </div>
        <div class="card-body">

        <div class="col-md-12">
          <div id="stepper1" class="bs-stepper">
            <div class="bs-stepper-header">
              <div class="step" data-target="#test-l-1">
                <button type="button" class="btn step-trigger">
                  <span class="bs-stepper-circle">1</span>
                  <span class="bs-stepper-label">Create New Item</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step" data-target="#test-l-2">
                <button type="button" class="btn step-trigger">
                  <span class="bs-stepper-circle">2</span>
                  <span class="bs-stepper-label">Second step</span>
                </button>
              </div>
              <div class="line"></div>
              <div class="step" data-target="#test-l-3">
                <button type="button" class="btn step-trigger">
                  <span class="bs-stepper-circle">3</span>
                  <span class="bs-stepper-label">Third step</span>
                </button>
              </div>
            </div>

            <div class="bs-stepper-content">
              <div id="test-l-1" class="content">

                    <form class="text-center border border-light p-5" action="" id="itemCreate" onsubmit="return false;">
                        <div class="col-lg-10">
                            <div class="form-group">
                            <select id="supplier" name="supplier" class="browser-default custom-select mb-4 selectpicker" required>
                                <option value="">Choose Supplier</option>
                                @foreach ($suppliers as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-10">
                            <div class="form-group">
                                <input type="text" class="form-control" name="product_code" id="product_code" required=""
                                value="" autocomplete="off"  placeholder="Product Code">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <button class="btn btn-primary btn-block" type="submit">Create</button>
                        </div>
                    </form>

                <button class="btn btn-primary btn-next" onclick="stepper1.next()" style="display:none;">Next</button>
              </div>
              <div id="test-l-2" class="content">
                <p class="text-center">test 2</p>
                <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
              </div>
              <div id="test-l-3" class="content">
                <p class="text-center">test 3</p>
                <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
              </div>
            </div>
          </div>
        </div>

    </div>
    @section('js')
    <!-- <script src="dist/js/bs-stepper.js"></script> -->
    <script>

        // Form stepper
      var stepper1Node = document.querySelector('#stepper1')
      var stepper1 = new Stepper(document.querySelector('#stepper1'))

      stepper1Node.addEventListener('show.bs-stepper', function (event) {
        console.warn('show.bs-stepper', event)
      })
      stepper1Node.addEventListener('shown.bs-stepper', function (event) {
        console.warn('shown.bs-stepper', event)
      })

      // Select picker
        const sorting = document.querySelector('.selectpicker');
        const commentSorting = document.querySelector('.selectpicker');
        const sortingchoices = new Choices(sorting, {
            placeholder: false,
            itemSelectText: ''
        });

        let sortingClass = sorting.getAttribute('class');
        window.onload= function () {
            sorting.parentElement.setAttribute('class', sortingClass);
        }
    </script>

    <script>
        $(document).ready(function() {

            $("form").submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ url('admin/item/store') }}",
                    type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "supplier": $('#supplier').val(),
                            "product_code": $('#product_code').val()
                        },
                            success: function (data) {
                            var result = JSON.parse(data);
                                    if (result == 1) {
                                        $('.btn-next').show();
                                    } else {
                                        toastr.error(
                                            'Error',
                                            'Something Went Wrong!',
                                            {
                                                timeOut: 1500,
                                                fadeOut: 1500,
                                                onHidden: function () {
                                                    window.location.reload();
                                                }
                                            }
                                        );
                                    }
                        }, error: function (data) {
                                    
                    }
                });
            });
        });
    </script>
    @endsection
</x-admin>