// Let's make <Card text='Write the docs' /> draggable!

import { ListItemText } from "@mui/material";
import { useDrag } from "react-dnd";

/**
 * Your Component
 */
export default function Task({ color: bgColor, id, name }: any) {
    const [{ opacity, color }, dragRef] = useDrag(
        () => ({
            type: "taskcard",
            item: { id, name },
            collect: (monitor) => ({
                opacity: monitor.isDragging() ? 0 : 1,
                color: monitor.isDragging() ? "green" : "red",
            }),
        }),
        []
    );
    return (
        <ListItemText
            sx={{
                opacity: opacity,
                backgroundColor: bgColor,
                cursor: "pointer",
                color: "white",
            }}
            ref={dragRef}
            primary={name}
        />
    );
}
