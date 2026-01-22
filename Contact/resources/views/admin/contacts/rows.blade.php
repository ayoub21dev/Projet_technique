@forelse($contacts as $contact)
  @include('admin.contacts.row', ['contact' => $contact])
@empty
<tr>
  <td colspan="4" class="px-6 py-20 text-center text-sm text-slate-500">No contacts found.</td>
</tr>
@endforelse
