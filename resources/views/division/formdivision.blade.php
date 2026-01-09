@section('title', 'Verifika - Generar divisiones')
<x-guest-layout>
	<div class="flex flex-col items-center justify-center min-h-[60vh] px-2">
		<div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 sm:p-8 border border-gray-100 dark:border-corp-dark">
			<h1 class="text-2xl font-bold text-center mb-6 text-corp dark:text-corp tracking-tight">Generar divisiones</h1>
			<form method="POST" action="{{ route('divisiones.nueva.generar') }}" class="space-y-6">
				@csrf
				<div class="px-2 sm:px-4">
					<x-input-label for="dificultad" :value="'Dificultad'" class="font-semibold text-corp" />
					<select name="dificultad" id="dificultad" class="block mt-1 w-full rounded-lg border-corp dark:border-corp-dark focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800">
						<option value="FACILINGO">FACILINGO</option>
						<option value="FACIL">FACIL</option>
						<option value="NORMAL">NORMAL</option>
						<option value="DIFICIL">DIFICIL</option>
						<option value="SUPERDIFICIL">SUPERDIFICIL</option>
						<option value="ULTRADIFICIL">ULTRADIFICIL</option>
						<option value="TIPOEXAMEN">TIPOEXAMEN</option>
					</select>
				</div>
				<div class="px-2 sm:px-4">
					<x-input-label for="digitos_dividendo" :value="'Cantidad de dígitos del dividendo'" class="font-semibold text-corp" />
					<x-text-input id="digitos_dividendo" class="block mt-1 w-full rounded-lg border-corp dark:border-corp-dark focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="number" name="digitos_dividendo" required min="1" placeholder="Ej: 3" />
				</div>
				<div class="px-2 sm:px-4">
					<x-input-label for="digitos_divisor" :value="'Cantidad de dígitos del divisor'" class="font-semibold text-corp" />
					<x-text-input id="digitos_divisor" class="block mt-1 w-full rounded-lg border-corp dark:border-corp-dark focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="number" name="digitos_divisor" required min="1" placeholder="Ej: 2" />
				</div>
				<div class="px-2 sm:px-4">
					<x-input-label for="cantidad" :value="'Cantidad de ejercicios a generar'" class="font-semibold text-corp" />
					<x-text-input id="cantidad" class="block mt-1 w-full rounded-lg border-corp dark:border-corp-dark focus:border-corp focus:ring-corp bg-gray-50 dark:bg-gray-800" type="number" name="cantidad" required min="1" max="50" placeholder="Ej: 10" />
				</div>
				<div class="px-2 sm:px-4 text-center">
					<x-primary-button class="w-full py-3 rounded-lg text-base font-bold bg-corp hover:bg-corp-dark transition-colors flex items-center justify-center">
						Generar divisiones
					</x-primary-button>
				</div>
			</form>
		</div>
	</div>
</x-guest-layout>
<!-- Archivo eliminado para crear un nuevo formulario de división moderno -->
