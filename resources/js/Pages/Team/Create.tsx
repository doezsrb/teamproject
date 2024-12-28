import AuthenticatedLayoutDrawer from "@/Layouts/AuthenticatedLayoutDrawer";
import { useForm } from "@inertiajs/react";
import {
    Box,
    Button,
    CssBaseline,
    Stack,
    TextField,
    Typography,
} from "@mui/material";

const Create = () => {
    const form = useForm({
        name: "",
    });
    return (
        <AuthenticatedLayoutDrawer>
            <Box>
                <Typography variant="h5" align="center">
                    Create Team
                </Typography>
                <Stack>
                    <TextField
                        value={form.data.name}
                        onChange={(e: any) => {
                            form.setData("name", e.target.value);
                        }}
                        variant="outlined"
                        label="Team name"
                    />
                    <Button
                        onClick={() => {
                            form.put(route("team.create"), {
                                onSuccess: () => {
                                    console.log("success");
                                },
                                onError: (error) => {
                                    console.log(error);
                                },
                            });
                        }}
                    >
                        Create
                    </Button>
                </Stack>
            </Box>
        </AuthenticatedLayoutDrawer>
    );
};

export default Create;
