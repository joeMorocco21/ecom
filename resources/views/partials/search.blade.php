<form action="{{ route('products.search') }}" class="d-flex mr-3"> 
<div class="form-group mb-0 mr-1">
<input type="text" name="q" class="form-control" value="{{ request()->q ??  '' }}">
</div>
<button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-search"></span></button>
</form>