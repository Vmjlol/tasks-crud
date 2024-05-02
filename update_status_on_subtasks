
DELIMITER $$

CREATE TRIGGER update_status_pending_subtasks
AFTER UPDATE ON tasks
FOR EACH ROW
BEGIN
    IF NEW.status = 'pending' THEN
        UPDATE subtasks
        SET status = 'pending'
        WHERE subtasks.id_task = NEW.id;
    END IF;
END$$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER update_status_completed_subtasks
AFTER UPDATE ON tasks
FOR EACH ROW
BEGIN
    IF NEW.status = 'completed' THEN
        UPDATE subtasks
        SET status = 'completed'
        WHERE subtasks.id_task = NEW.id;
    END IF;
END$$

DELIMITER ;