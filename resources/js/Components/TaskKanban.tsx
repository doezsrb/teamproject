import { Box, List, ListItemText, Typography } from "@mui/material";
import { useState } from "react";
import { useDrop } from "react-dnd";
import Task from "./Task";
import { router } from "@inertiajs/react";

const TaskKanban = ({ pendingTasks, progressTasks, doneTasks }: any) => {
    const [pending, setPending] = useState<any>(pendingTasks);
    const [progress, setProgress] = useState<any>(progressTasks);
    const [done, setDone] = useState<any>(doneTasks);
    const [{ isOverPending }, dropPendingRef] = useDrop({
        accept: "taskcard",
        drop: (item: any) => {
            var newPending = pending.filter(
                (penItem: any) => penItem.id != item.id
            );
            var newProgress = progress.filter(
                (proItem: any) => proItem.id != item.id
            );
            var newDone = done.filter(
                (doneItem: any) => doneItem.id != item.id
            );
            setPending(newPending);
            setProgress(newProgress);
            setDone(newDone);
            setPending((oldPending: any) => [...oldPending, item]);
            router.post(route("task.update", item.id), {
                status: "pending",
            });
        },
        collect: (monitor) => ({
            isOverPending: monitor.isOver(),
        }),
    });
    const [{ isOverProgress }, dropProgressRef] = useDrop({
        accept: "taskcard",
        drop: (item: any) => {
            var newPending = pending.filter(
                (penItem: any) => penItem.id != item.id
            );
            var newProgress = progress.filter(
                (proItem: any) => proItem.id != item.id
            );
            var newDone = done.filter(
                (doneItem: any) => doneItem.id != item.id
            );
            setPending(newPending);
            setProgress(newProgress);
            setDone(newDone);
            setProgress((oldProgress: any) => [...oldProgress, item]);
            router.post(route("task.update", item.id), {
                status: "in_progress",
            });
        },
        collect: (monitor) => ({
            isOverProgress: monitor.isOver(),
        }),
    });
    const [{ isOverDone }, dropDoneRef] = useDrop({
        accept: "taskcard",
        drop: (item: any) => {
            var newPending = pending.filter(
                (penItem: any) => penItem.id != item.id
            );
            var newProgress = progress.filter(
                (proItem: any) => proItem.id != item.id
            );
            var newDone = done.filter(
                (doneItem: any) => doneItem.id != item.id
            );
            setPending(newPending);
            setProgress(newProgress);
            setDone(newDone);
            setDone((oldDone: any) => [...oldDone, item]);
            router.post(route("task.update", item.id), {
                status: "completed",
            });
        },
        collect: (monitor) => ({
            isOverDone: monitor.isOver(),
        }),
    });
    return (
        <Box
            width={"100%"}
            height={200}
            border={1}
            borderColor={"gray"}
            p={2}
            display={"flex"}
            gap={5}
            flexDirection={"row"}
        >
            <Box
                height={150}
                ref={dropPendingRef}
                width={"100%"}
                border={1}
                borderColor={"blue"}
            >
                <Typography variant="h6" color="blue" textAlign={"center"}>
                    Pending
                </Typography>
                <List>
                    {pending.map((task: any) => (
                        <Task
                            color={"blue"}
                            name={task.name}
                            key={task.id}
                            id={task.id}
                        />
                    ))}
                </List>
            </Box>
            <Box
                height={150}
                ref={dropProgressRef}
                width={"100%"}
                border={1}
                borderColor={"orange"}
            >
                <Typography variant="h6" color="orange" textAlign={"center"}>
                    In progress
                </Typography>
                <List>
                    {progress.map((task: any) => (
                        <Task
                            color={"orange"}
                            name={task.name}
                            key={task.id}
                            id={task.id}
                        />
                    ))}
                </List>
            </Box>
            <Box
                height={150}
                ref={dropDoneRef}
                width={"100%"}
                border={1}
                borderColor={"green"}
            >
                <Typography variant="h6" color="green" textAlign={"center"}>
                    Done
                </Typography>
                <List>
                    {done.map((task: any) => (
                        <Task
                            color="green"
                            name={task.name}
                            key={task.id}
                            id={task.id}
                        />
                    ))}
                </List>
            </Box>
        </Box>
    );
};

export default TaskKanban;
