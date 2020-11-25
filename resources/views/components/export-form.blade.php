<form action="{{ route('export') }}" method="get" class="text-center">
  @csrf
  <div class="form-group text-center">
    <label><strong>Choose your format: </strong></label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="fileFormat" id="CSV" value="CSV" checked>
      <label class="form-check-label" for="CSV">CSV</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="fileFormat" id="XML" value="XML">
      <label class="form-check-label" for="XML">XML</label>
    </div>
  </div>
  <div class="form-group text-center">
    <label><strong>Select the columns: </strong></label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="Title" value="Title" name="Title" checked>
      <label class="form-check-label" for="Title">Titles</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" id="Author" value="Author" name="Author" checked>
      <label class="form-check-label" for="Author">Authors</label>
    </div>
  </div>
  <button type="submit" class="btn btn-success"><i class="fas fa-download text-white px-5"></i></button>
</form>
