<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <style>
            html {background-color: #2d3748; justify-content: center; display: flex}
            body { font-family: SansSerif, serif; padding: 30px; background-color: white; border-radius: 20px; width: 70%;}
            svg { width: 14px !important }
            .header { grid-area: header; }
            .main { grid-area: main; }
            .footer { grid-area: footer; display: block}
            li {
                padding: 4px;
                margin-bottom: 5px;
                border-radius: 5px;
            }

            /*drop downs*/
            summary::-webkit-details-marker {
                color: #e7e7e7;
                font-size: 125%;
                margin-right: 2px;
            }
            summary:hover { cursor: pointer; background-color: #e1f3fa
            }
            summary:focus {
                outline-style: none;
            }
            article > details > summary {
                font-size: 28px;
                margin-top: 16px;
            }
            details > p {
                margin-left: 24px;
            }
            details details {
                margin-left: 36px;
            }
            details details summary {
                font-size: 16px;
            }
        </style>
        <style class="darkreader darkreader--sync" media="screen"></style>
    </head>
    <body class="antialiased">
    <section>
        <article>

        <summary class="w3-text-teal" style="font-size: 25px;"><strong>Projects</strong></summary>
        <div class="main" style="margin-top: 10px">
            @foreach($projects as $project)
                <div style="margin-top: 10px; margin-bottom: 10px; background-color: #d7d7d7; padding: 10px; border-radius: 10px">
                    <details>
                        <summary><strong>Title: </strong> <span>{{$project->title}}</span></summary>
                        <ul>
                            <li>
                                <strong>Description: </strong> <span>{{$project->description}}</span>
                            </li>
                            <li>
                                <strong>Client | Company: </strong> <span>{{$project->client ?? $project->company}}</span>
                            </li>
                            <li>
                                <strong>Duration: </strong> <span>From <span style="text-decoration: underline">{{$project->begin_at}}</span> to <span style="text-decoration: underline">{{$project->finish_at}}</span>, {{$project->duration}}</span>
                            </li>
                            <li>
                                <strong>Status: </strong> <span>{{$project->status}}</span>
                            </li>
                        </ul>
                        <div style="font-size: small">
                            @if (count($project->tasks) > 0)
                            <details>
                                <summary><strong>Tasks: </strong></summary>
                                <ul>
                                    @foreach($project->tasks as $task)
                                        <li style="list-style: lower-roman;">
                                            <strong>Task name: </strong> <span>{{$task->name}}</span>
                                            @if($task->completed)
                                                <strong>(Done)</strong>
                                            @else
                                                <span>(Pending)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </details>
                            @else
                                <strong style="margin-left: 20px">No tasks yet.</strong>
                            @endif
                        </div>
                    </details>
                </div>
            @endforeach
        </div>
        <div class="footer">
            {{ $projects->links() }}
        </div>
        </article>
    </section>
    </body>
</html>


