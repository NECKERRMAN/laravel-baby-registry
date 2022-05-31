<tr>
    <td data-label="{{ ucfirst(__('name'))}}">{{ $registry->name }}</td>
    <td data-label="{{ ucfirst(__('link_ff'))}}">storksie.be/registry/{{ $registry->slug }}</td>
    <td data-label="{{ ucfirst(__('action'))}}">
       <div class="flex md:flex-row flex-col items-center">
        <a class="link-btn inline-block w-full text-center m-0 sm:mb-4 mb-2 md:mr-2" href="{{ route('registry.edit', $registry->id )}}">{{ ucfirst(__('edit')) }}</a>
        <a class="link-btn inline-block w-full text-center  m-0 sm:mb-4 mb-2" href="{{ route('registry.overview', $registry->id )}}">{{ ucfirst(__('overview')) }}</a>
       </div>
    </td>
</tr>