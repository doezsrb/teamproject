<x-mail::message>
# Introduction
Daily task raport of your projects

<x-mail::table>
| Projects         | Tasks      |
| :----------- | ------------: |
@foreach($projects as $project)
| {{$project->name}}         | {{$project->completed_tasks_count}} / {{$project->tasks_count}}   |  

@endforeach

</x-mail::table>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
